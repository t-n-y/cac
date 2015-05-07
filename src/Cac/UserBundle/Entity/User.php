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
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\PromoOffertes", mappedBy="user")
     */
    private $PromoOffertes;

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
     * Add PromoOffertes
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $PromoOffertes
     * @return BasicUser
     */
    public function addVerresOffert(\Cac\BarBundle\Entity\PromoOffertes $PromoOffertes)
    {
        $this->PromoOffertes[] = $PromoOffertes;

        return $this;
    }

    /**
     * Remove PromoOffertes
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $PromoOffertes
     */
    public function removeVerresOffert(\Cac\BarBundle\Entity\PromoOffertes $PromoOffertes)
    {
        $this->PromoOffertes->removeElement($PromoOffertes);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
    	parent::__construct();
        $this->PromoOffertes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get PromoOffertes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPromoOffertes()
    {
        return $this->PromoOffertes;
    }

    public function setEmail($email){
        parent::setEmail($email);
        $this->setUsername($email);
    }
}
