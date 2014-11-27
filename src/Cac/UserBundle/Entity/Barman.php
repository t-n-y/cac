<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * Barman
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\UserBundle\Entity\BarmanRepository")
 * @UniqueEntity(fields = "username", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Barman extends User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="barman")
     * @ORM\JoinColumn(name="bar_id", referencedColumnName="id")
     */
    protected $bar;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->roles = array('ROLE_BARMAN');
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     * @return Barman
     */
    public function setBar(\Cac\BarBundle\Entity\Bar $bar = null)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * Get bar
     *
     * @return \Cac\BarBundle\Entity\Bar 
     */
    public function getBar()
    {
        return $this->bar;
    }
}
