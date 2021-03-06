<?php

namespace AppBundle\Entity\Tache;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Composant\PrincipalesInformation\PrincipalesInformation;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\GreaterThan(-1)
     * @ORM\Column(name="ordre", type="integer", nullable=true, unique=false)
     */
    private $ordre;

    /**
     * @ORM\Column(name="est_archivee", type="boolean", nullable=false, unique=false)
     */
    private $est_archivee;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->est_archivee = false;
        $this->ordre = 0;
    }

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
     * Get the value of ordre
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set the value of ordre
     *
     * @return  self
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Set estArchivee
     *
     * @param boolean $estArchivee
     *
     * @return Tache
     */
    public function setEstArchivee($estArchivee)
    {
        $this->est_archivee = $estArchivee;

        return $this;
    }

    /**
     * Get estArchivee
     *
     * @return boolean
     */
    public function getEstArchivee()
    {
        return $this->est_archivee;
    }
}
