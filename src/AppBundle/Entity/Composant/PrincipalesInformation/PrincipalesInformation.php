<?php

namespace AppBundle\Entity\Composant\PrincipalesInformation;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Service\GuidGenerator;

class PrincipalesInformation
{
        /** @ORM\Column(name="date_creation", type="datetime", nullable=false, unique=false) */
        protected $date_creation;

        /** @ORM\Column(name="date_mise_a_jour", type="datetime", nullable=false, unique=false) */
        protected $date_mise_a_jour;

        /**
         * @var guid
         *
         * @ORM\Column(name="guid", type="guid", nullable=false, unique=true)
         */
        protected $guid;

        /**
         * @var string
         *
         * @ORM\Column(name="nom", type="string", length=100, nullable=false, unique=false)
         */
        protected $nom;

        /**
         * @var string
         *
         * @ORM\Column(name="statut", type="string", length=100, nullable=false, unique=false)
         */
        protected $statut;

        /**
         * @var string
         *
         * @ORM\Column(name="description", type="string", length=500, nullable=true, unique=false)
         */
        protected $description;

        /**
         * @var string
         *
         * @ORM\Column(name="objectif", type="string", length=500, nullable=true, unique=false)
         */
        protected $objectif;

        /**
         * @var string
         *
         * @ORM\Column(name="remarque", type="string", length=500, nullable=true, unique=false)
         */
        protected $remarque;        

        /**
         * Constructor
         */
        public function __construct()
        {
                $this->date_creation = new \DateTime("now");
                $this->date_mise_a_jour = new \DateTime("now");
                $guidObj = new GuidGenerator();
                $this->setGuid($guidObj->GUIDv4());
                $this->statut = "#NA";
        }


        /**
         * Set dateCreation
         *
         * @param \DateTime $dateCreation
         *
         * @return Adresse
         */
        public function setDateCreation($dateCreation)
        {
                $this->date_creation = $dateCreation;

                return $this;
        }

        /**
         * Get dateCreation
         *
         * @return \DateTime
         */
        public function getDateCreation()
        {
                return $this->date_creation;
        }

        /**
         * Set dateMiseAJour
         *
         * @param \DateTime $dateMiseAJour
         *
         * @return Adresse
         */
        public function setDateMiseAJour($dateMiseAJour)
        {
                $this->date_mise_a_jour = $dateMiseAJour;

                return $this;
        }

        /**
         * Get dateMiseAJour
         *
         * @return \DateTime
         */
        public function getDateMiseAJour()
        {
                return $this->date_mise_a_jour;
        }

        /**
         * Get the value of guid
         *
         * @return  guid
         */
        public function getGuid()
        {
                return $this->guid;
        }

        /**
         * Set the value of guid
         *
         * @param  guid  $guid
         *
         * @return  self
         */
        public function setGuid($guid)
        {
                $this->guid = $guid;

                return $this;
        }


        /**
         * Get the value of nom
         *
         * @return  string
         */
        public function getNom()
        {
                return $this->nom;
        }

        /**
         * Set the value of nom
         *
         * @param  string  $nom
         *
         * @return  self
         */
        public function setNom(string $nom)
        {
                $this->nom = $nom;

                return $this;
        }

        /**
         * Get the value of description
         *
         * @return  string
         */
        public function getDescription()
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @param  string  $description
         *
         * @return  self
         */
        public function setDescription(string $description)
        {
                $this->description = $description;

                return $this;
        }


        /**
         * Set statut
         *
         * @param string $statut
         *
         * @return  self
         */
        public function setStatut($statut)
        {
                $this->statut = $statut;

                return $this;
        }

        /**
         * Get statut
         *
         * @return string
         */
        public function getStatut()
        {
                return $this->statut;
        }

        /**
         * Set objectif
         *
         * @param string $objectif
         *
         * @return  self
         */
        public function setObjectif($objectif)
        {
                $this->objectif = $objectif;

                return $this;
        }

        /**
         * Get objectif
         *
         * @return string
         */
        public function getObjectif()
        {
                return $this->objectif;
        }

        /**
         * Set remarque
         *
         * @param string $remarque
         *
         * @return  self
         */
        public function setRemarque($remarque)
        {
                $this->remarque = $remarque;

                return $this;
        }

        /**
         * Get remarque
         *
         * @return string
         */
        public function getRemarque()
        {
                return $this->remarque;
        }
}