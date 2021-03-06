<?php
/***********************************************************************************************************************
 * Projet: Phpmesure
 * Auteur: Tristan Fleury - tristan.fleury.gre@gmail.com
 * Année de production: 2017
 * Licence: GNU General Public License (GPL), version 3
 * Copyright © 2017 Tristan Fleury
 **********************************************************************************************************************/
namespace viduc\phpmesureserveurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mesure
 *
 * @ORM\Table(name="mesure")
 * @ORM\Entity(repositoryClass="viduc\phpmesureserveurBundle\Repository\MesureRepository")
 */
class Mesure
{
    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="mesures")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;

    /**
     * @ORM\ManyToOne(targetEntity="Classname", inversedBy="mesures")
     * @ORM\JoinColumn(name="classname_id", referencedColumnName="id")
     */
    private $classname;
    
    /**
     * @ORM\ManyToOne(targetEntity="Methode", inversedBy="methodes")
     * @ORM\JoinColumn(name="methodee_id", referencedColumnName="id")
     */
    private $methode;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=50)
     */
    private $ip;

    /**
     * @var float
     *
     * @ORM\Column(name="duree", type="float")
     */
    private $duree;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set application
     *
     * @param Application $application
     *
     * @return Mesure
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return Application
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set classname
     *
     * @param Classname $classname
     *
     * @return Mesure
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;

        return $this;
    }

    /**
     * Get classname
     *
     * @return Classname
     */
    public function getClassname()
    {
        return $this->classname;
    }
    
    /**
     * Set methode
     *
     * @param Methode $methode
     *
     * @return Mesure
     */
    public function setMethode($methode)
    {
        $this->methode = $methode;

        return $this;
    }

    /**
     * Get methode
     *
     * @return Methode
     */
    public function getMethode()
    {
        return $this->methode;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Mesure
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Mesure
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set dur�ee
     *
     * @param float $duree
     *
     * @return Mesure
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return float
     */
    public function getDuree()
    {
        return $this->duree;
    }
}