<?php
/***********************************************************************************************************************
 * Projet: Phpmesure
 * Auteur: Tristan Fleury - tristan.fleury.gre@gmail.com
 * Année de production: 2017
 * Licence: GNU General Public License (GPL), version 3
 * Copyright © 2017 Tristan Fleury
 **********************************************************************************************************************/

namespace viduc\phpmesureserveurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use viduc\phpmesureserveurBundle\Entity\Mesure;
use viduc\phpmesureserveurBundle\Entity\Application;

class DefaultController extends Controller
{

    private $dernierAcces;
    private $activeMenu;
    
    public function __construct() 
    {
        $this->setDernierAcces("01 janvier 1970"); // a implémenter
    }
    
    /**
     * Entrée principale de l'application
     * @return view
     */
    public function indexAction()
    {
        $this->setActiveMenu("tableauDeBord");
        return $this->render('viducphpmesureserveurBundle:Default:index.html.twig',
            array('dernierAcces'=>$this->getDernierAcces(), 'activeMenu'=>$this->getActiveMenu(),
                'applications'=>$this->getListeApplication()));
    }
    
    /**
     * Envoie les informations relatives à une application
     * @param String $application
     * @return view
     */
    public function applicationAction($application)
    {
        $this->setActiveMenu($application);
        $em = $this->getDoctrine()->getManager();
        $applicationDB = $em->getRepository(Application::class)->findOneBy(array('application'=>$application));
        
        return $this->render('viducphpmesureserveurBundle:Default:application.html.twig',
            array('dernierAcces'=>$this->getDernierAcces(), 'activeMenu'=>$this->getActiveMenu(),
                'applications'=>$this->getListeApplication(),'application'=>$applicationDB,
                'listeMethode'=>$this->getListeMethode($applicationDB)));
    }
    
    /**
     * Récupère la liste des applications actives
     */
    public function getListeApplication()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository(Application::class)->findBy(array('vie'=>true));
    }
    
    
    private function getListeMethode($application)
    {
        $em = $this->getDoctrine()->getManager();
        $mesures = $em->getRepository(Mesure::class);
        
        $methodes = $mesures->createQueryBuilder('mesure')
        ->select('mesure')
        ->where('mesure.application = :application')
        ->setParameter('application', $application)
        ->distinct()
        ->getQuery();
        $listeMethode = null;
        foreach($methodes->getResult() as $methode){
            $listeMethode[$methode->getMethode()]['nbr'] = 
                $this->getNombreUtilisationMethode($application,$methode->getMethode());
            $listeMethode[$methode->getMethode()]['temps'] = 
                $this->getTempsExecutionMethode($application,$methode->getMethode(),$interval=null);
        }
        return $listeMethode;
    }
    
    /**
     * 
     * @param type $methode
     * @param type $interval
     * @return type
     */
    private function getNombreUtilisationMethode($application,$methode, $interval=null)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Mesure::class)->createQueryBuilder('a');
        $qb->select('COUNT(a)');
        $qb->where('a.application = :application');
        $qb->andWhere('a.methode = :methode');
        $qb->setParameter('methode', $methode);
        $qb->setParameter('application', $application);
        if(!$interval){
        }
        return $qb->getQuery()->getSingleScalarResult();
    }
    
    
    private function getTempsExecutionMethode($application,$methode,$interval=null)
    {
        $nbr = $this->getNombreUtilisationMethode($application,$methode,$interval);
        $em = $this->getDoctrine()->getManager();
        
        $qb = $em->getRepository(Mesure::class)->createQueryBuilder('mesure');
        $qb->select('mesure');
        $qb->where('mesure.application = :application');
        $qb->andWhere('mesure.methode = :methode');
        $qb->setParameter('methode', $methode);
        $qb->setParameter('application', $application);
        $mesures = $qb->getQuery()->getResult();
        
        $additionTemps = null;
        foreach($mesures as $mesure)
        {
            $additionTemps += $mesure->getDuree();
        }
        return $additionTemps/$nbr;
    }
    
    
/***********************************************************************************************************************
 * GETTER ET SETTER 
 **********************************************************************************************************************/ 
    /**
     * Setter dernierAcces
     * @param String $dernierAcces - la date du dernier accès de l'utilisateur
     * @return $this
     */
    public function setDernierAcces($dernierAcces)
    {
        $this->dernierAcces = $dernierAcces;
        return $this;
    }
    
    /**
     * Getter dernierAcces
     * @return String
     */
    public function getDernierAcces()
    {
        return $this->dernierAcces;
    }
    
    /**
     * Setter activeMenu
     * @param String $activeMenu - Le menu actif
     * @return $this
     */
    public function setActiveMenu($activeMenu)
    {
        $this->activeMenu = $activeMenu;
        return $this;
    }
    
    /**
     * Getter activeMenu
     * @return String
     */
    public function getActiveMenu()
    {
        return $this->activeMenu;
    }    
}
