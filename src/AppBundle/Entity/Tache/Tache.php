<?php

namespace AppBundle\Entity\Tache;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Composant\PrincipalesInformation\PrincipalesInformation;

/**
 * Tache
 *
 * @ORM\Table(name="tache")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TacheRepository")
 */
class Tache extends PrincipalesInformation
{
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
     * @ORM\Column(name="statut", type="string", length=255, nullable=false, unique=false)
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="objectif", type="string", length=255, nullable=true, unique=false)
     */
    private $objectif;

    /**
     * @var string
     *
     * @ORM\Column(name="remarque", type="string", length=255, nullable=true, unique=false)
     */
    private $remarque;


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
     * Set statut
     *
     * @param string $statut
     *
     * @return Tache
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
     * @return Tache
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
     * @return Tache
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
