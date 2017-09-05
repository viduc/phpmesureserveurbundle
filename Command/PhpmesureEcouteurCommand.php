<?php 
/***********************************************************************************************************************
 * Projet: Phpmesure
 * Auteur: Tristan Fleury - tristan.fleury.gre@gmail.com
 * Année de production: 2017
 * Licence: GNU General Public License (GPL), version 3
 * Copyright © 2017 Tristan Fleury
 **********************************************************************************************************************/
namespace viduc\phpmesureserveurBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use viduc\phpmesureserveurBundle\Entity\Mesure;
use viduc\phpmesureserveurBundle\Entity\Application;
use viduc\phpmesureserveurBundle\Entity\Classname;
use viduc\phpmesureserveurBundle\Entity\Methode;

class PhpmesureEcouteurCommand extends ContainerAwareCommand
{
    /**
     * Méthode de configuration de la commande
     */
    protected function configure()
    {
        $this
            ->setName('phpmesure:ecouteur')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * Méthode execute de la commande
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
       /* $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }*/
        $buf = null;
        error_reporting(E_ALL | E_STRICT);

        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_bind($socket, '127.0.0.1', 1223);

        $from = '';
        $port = 1223;
        while(true){
            socket_recvfrom($socket, $buf, 3000, 0, $from, $port);
            $output->writeln("Réception de $buf depuis l'adresse distant $from " . PHP_EOL);
            $json = json_decode($buf);
            
            /* récupération du service em */
            $em = $this->getContainer()->get('doctrine')->getManager();
            
            /* récupération / création de l'enregistrement Application */
            $repository = $em->getRepository(Application::class);
            $application = $repository->findOneByApplication($json->application);
            if(!$application){
                $application = new Application();
                $application->setApplication($json->application);
                $application->setDescription("Application enregistrée via écouteur du serveur");
                $application->setDate(new \DateTime('NOW'));
                $application->setVie(true);
            }
            
            /* récupération / création de l'enregistrement Classname */
            $repository = $em->getRepository(Classname::class);
            $classname = $repository->findOneBy(array('application' => $application, 'classname' => $json->classname));
            if(!$classname){
                $classname = new Classname();
                $classname->setApplication($application);
                $classname->setClassname($json->classname);
                $classname->setDescription("Class enregistrée via écouteur du serveur");
                $classname->setDate(new \DateTime('NOW'));
                $classname->setVie(true);
            }

            /* récupération / création de l'enregistrement Methode */
            $repository = $em->getRepository(Methode::class);
            $methode = $repository->findOneBy(
                array('application' => $application, 'classname' => $classname, 'methode' => $json->methode));
            if(!$methode){
                $methode = new Methode();
                $methode->setApplication($application);
                $methode->setClassname($classname);
                $methode->setMethode($json->methode);
                $methode->setDescription("Methode enregistrée via écouteur du serveur");
                $methode->setDate(new \DateTime('NOW'));
                $methode->setVie(true);
            }
            
            $mesure = new Mesure();
            $mesure->setApplication($application);
            $mesure->setClassname($classname);
            $mesure->setMethode($methode);
            $mesure->setDate(new \DateTime());
            $mesure->setIp($from);
            $mesure->setDuree($json->duree);
            
            $em->persist($application);
            $em->persist($classname);
            $em->persist($methode);
            $em->persist($mesure);
            $em->flush();
        }
        
    }

}
