<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var date $birthday
     *
     * @ORM\Column(name="birthday", type="datetime")
     * @Assert\DateTime()
     */
    private $birthday;

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

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Add promoOfferte
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $promoOfferte
     *
     * @return User
     */
    public function addPromoOfferte(\Cac\BarBundle\Entity\PromoOffertes $promoOfferte)
    {
        $this->PromoOffertes[] = $promoOfferte;

        return $this;
    }

    /**
     * Remove promoOfferte
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $promoOfferte
     */
    public function removePromoOfferte(\Cac\BarBundle\Entity\PromoOffertes $promoOfferte)
    {
        $this->PromoOffertes->removeElement($promoOfferte);
    }
}
