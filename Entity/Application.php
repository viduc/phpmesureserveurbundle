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
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="viduc\phpmesureserveurBundle\Repository\ApplicationRepository")
 */
class Application
{
    /**
     * @ORM\OneToMany(targetEntity="Mesure", mappedBy="applications")
     */
    private $mesures;
    
    /**
     * @ORM\OneToMany(targetEntity="Classname", mappedBy="classnames")
     */
    private $classnames;

    /**
     * @ORM\OneToMany(targetEntity="Methode", mappedBy="methodes")
     */
    private $methodes;
    
    public function __construct()
    {
        $this->mesures = new ArrayCollection();
        $this->classnames = new ArrayCollection();
        $this->methodes = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="application", type="string", length=255)
     */
    private $application;

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
     * @param string $application
     *
     * @return Application
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
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
     * @return Application
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
     * Add classname
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Classname $classname
     *
     * @return Application
     */
    public function addClassname(\viduc\phpmesureserveurBundle\Entity\Classname $classname)
    {
        $this->classnames[] = $classname;

        return $this;
    }

    /**
     * Remove classname
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Classname $classname
     */
    public function removeClassname(\viduc\phpmesureserveurBundle\Entity\Classname $classname)
    {
        $this->classnames->removeElement($classname);
    }

    /**
     * Get classnames
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassnames()
    {
        return $this->classnames;
    } 

    /**
     * Add methode
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Methode $methode
     *
     * @return Application
     */
    public function addMethode(\viduc\phpmesureserveurBundle\Entity\Methode $methode)
    {
        $this->methodes[] = $methode;

        return $this;
    }

    /**
     * Remove methode
     *
     * @param \viduc\phpmesureserveurBundle\Entity\Methode $methode
     */
    public function removeMethode(\viduc\phpmesureserveurBundle\Entity\Methode $methode)
    {
        $this->methodes->removeElement($methode);
    }

    /**
     * Get methodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMethodes()
    {
        return $this->methodes;
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