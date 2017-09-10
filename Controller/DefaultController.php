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
use viduc\phpmesureserveurBundle\Entity\Classname;

class DefaultController extends Controller
{

    /**
     * Date de la dernière connexion de l'utilisateur connecté
     * @var String 
     */
    private $dernierAcces;
    
    /**
     * Menu sélectionné lors du dernier appel
     * @var String 
     */
    private $activeMenu;
    
    /**
     * Liste des applications enregistrées et en vie
     * @var type 
     */
    private $listeDesApplications;
    
    /**
     * Constructeur de la class
     */
    public function __construct() 
    {
        
    }
    
    /**
     * Entrée principale de l'application
     * @return view
     */
    public function indexAction()
    {
        $this->setActiveMenu("tableauDeBord");
        return $this->render('viducphpmesureserveurBundle:Default:index.html.twig',
            array('configurationVue'=>$this->getConfigurationVue()));
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
            array('configurationVue'=>$this->getConfigurationVue(),'application'=>$applicationDB,
                'listeMesure'=>$this->getListeMesure($applicationDB)));
    }
    
    /**
     * Récupère les éléments de configuration standard pour les vues
     * Doit être passer en paramètre du render: 'configurationVue'=>$this->getConfigurationVue()
     * @return Array
     */
    private function getConfigurationVue()
    {
        if(is_null($this->getDernierAcces())){$this->setDernierAcces("01 janvier 1970");} // a implémenter
        if(is_null($this->getlisteDesApplications())){$this->genererListeApplication();}
        $retour["dernierAcces"] = $this->getDernierAcces();
        $retour["applications"] = $this->getlisteDesApplications();
        $retour["activeMenu"] = $this->getActiveMenu();
        return $retour;
    }
    
    
    /**
     * Génère la liste des applications actives depuis la base de données
     */
    private function genererListeApplication()
    {
        $em = $this->getDoctrine()->getManager();
        $this->setListeDesApplications($em->getRepository(Application::class)->findBy(array('vie'=>true)));
    }
    
    /**
     * 
     * @param type $application
     * @return type
     */
    private function getListeMesure($application)
    {
        $em = $this->getDoctrine()->getManager();
        $mesuresEM = $em->getRepository(Mesure::class);
        $mesures = $mesuresEM->findBy(array('application' => $application));
        $listeMesures = null;
        foreach($mesures as $mesure){
            if(isset($listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]
                ["nbr"])){
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["nbr"] = 
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["nbr"]+1;
            }
            else{
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["nbr"] = 1;
            }
            if(isset($listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]
                ["duree"])){
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["duree"] =
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["duree"] + 
                    $mesure->getDuree();
            }
            else{
                $listeMesures[$mesure->getClassname()->getClassname()][$mesure->getMethode()->getMethode()]["duree"] =
                    $mesure->getDuree();    
            }     
        }
        foreach($listeMesures as $class=>$mesures){
            foreach($mesures as $methode=>$mesure){
                $listeMesures[$class][$methode]["duree"] = $mesure["duree"] = $mesure["duree"] / $mesure["nbr"];
            }
        }
        return $listeMesures;
    }
    
    
/***********************************************************************************************************************
 * GETTER ET SETTER 
 **********************************************************************************************************************/ 
    /**
     * Setter dernierAcces
     * @param String $dernierAcces - la date du dernier accès de l'utilisateur
     * @return $this
     */
    private function setDernierAcces($dernierAcces)
    {
        $this->dernierAcces = $dernierAcces;
        return $this;
    }
    
    /**
     * Getter dernierAcces
     * @return String
     */
    private function getDernierAcces()
    {
        return $this->dernierAcces;
    }
    
    /**
     * Setter activeMenu
     * @param String $activeMenu - Le menu actif
     * @return $this
     */
    private function setActiveMenu($activeMenu)
    {
        $this->activeMenu = $activeMenu;
        return $this;
    }
    
    /**
     * Getter activeMenu
     * @return String
     */
    private function getActiveMenu()
    {
        return $this->activeMenu;
    }   
    
    /**
     * Setter listeDesApplications
     * @param Array $listeDesApplications - Liste des applications enregistrées
     * @return $this
     */
    private function setListeDesApplications($listeDesApplications)
    {
        $this->listeDesApplications = $listeDesApplications;
        return $this;
    }
    
    /**
     * Getter listeDesApplications
     * @return Array
     */
    private function getlisteDesApplications()
    {
        return $this->listeDesApplications;
    }     
}
