<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"bigboss" = "Bigboss", "barman" = "Barman", "basic_user" = "BasicUser"})
 *
 */
abstract class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\VerresOfferts", mappedBy="user")
     */
    private $verresOfferts;

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
     * Add verresOfferts
     *
     * @param \Cac\BarBundle\Entity\VerresOfferts $verresOfferts
     * @return BasicUser
     */
    public function addVerresOffert(\Cac\BarBundle\Entity\VerresOfferts $verresOfferts)
    {
        $this->verresOfferts[] = $verresOfferts;

        return $this;
    }

    /**
     * Remove verresOfferts
     *
     * @param \Cac\BarBundle\Entity\VerresOfferts $verresOfferts
     */
    public function removeVerresOffert(\Cac\BarBundle\Entity\VerresOfferts $verresOfferts)
    {
        $this->verresOfferts->removeElement($verresOfferts);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->verresOfferts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get verresOfferts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVerresOfferts()
    {
        return $this->verresOfferts;
    }
}
