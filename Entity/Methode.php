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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Mesure
 *
 * @ORM\Table(name="methode")
 * @ORM\Entity(repositoryClass="viduc\phpmesureserveurBundle\Repository\MethodeRepository")
 */
class Methode
{
    /**
     * @ORM\ManyToOne(targetEntity="Application", inversedBy="applications")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     */
    private $application;
 
    /**
     * @ORM\ManyToOne(targetEntity="Classname", inversedBy="classnames")
     * @ORM\JoinColumn(name="classname_id", referencedColumnName="id")
     */
    private $classname;
    
    /**
     * @ORM\OneToMany(targetEntity="Mesure", mappedBy="mesures")
     */
    private $mesures;

    public function __construct()
    {
        $this->mesures = new ArrayCollection();
    }
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var String 
     * 
     * @ORM\Column(name="methode", type="string", length=255)
     */
    private $methode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
        /**
     * @var Boolean
     *
     * @ORM\Column(name="vie", type="boolean")
     */
    private $vie;

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
     * @return Classname
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
     * @return Methode
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
     * @param string $methode
     *
     * @return Methode
     */
    public function setMethode($methode)
    {
        $this->methode = $methode;

        return $this;
    }

    /**
     * Get methode
     *
     * @return string
     */
    public function getMethode()
    {
        return $this->methode;
    }
    
    /**
     * Set description
     *
     * @param string $description
     *
     * @return Application
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Add mesure
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Mesure $mesure
     *
     * @return Classname
     */
    public function addMesure(\viduc\phpmesureserveurBundle\Entity\Mesure $mesure)
    {
        $this->mesures[] = $mesure;

        return $this;
    }

    /**
     * Remove mesure
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Mesure $mesure
     */
    public function removeMesure(\viduc\phpmesureserveurBundle\Entity\Mesure $mesure)
    {
        $this->mesures->removeElement($mesure);
    }

    /**
     * Get mesures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesures()
    {
        return $this->mesures;
    }    
    
    /**
     * Set vie
     *
     * @param Boolean $vie
     *
     * @return Mesure
     */
    public function setVie($vie)
    {
        $this->vie = $vie;

        return $this;
    }

    /**
     * Get vie
     *
     * @return Boolean
     */
    public function getVie()
    {
        return $this->vie;
    }    
}