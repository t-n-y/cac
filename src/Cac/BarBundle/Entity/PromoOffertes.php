<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromoOffertes
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\PromoOffertesRepository")
 */
class PromoOffertes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="PromoOffertes")
     */
    private $bar;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\UserBundle\Entity\User", inversedBy="PromoOffertes")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbpersonne", type="integer")
     */
    private $nbpersonne;

    /**
     * @var string
     *
     * @ORM\Column(name="hour", type="string", length=255)
     */
    private $hour;

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
     * Set reference
     *
     * @param string $reference
     * @return PromoOffertes
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set etat
     *
     * @param string $etat
     * @return PromoOffertes
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string 
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return PromoOffertes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     * @return PromoOffertes
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

    /**
     * Set user
     *
     * @param \Cac\UserBundle\Entity\User $user
     * @return PromoOffertes
     */
    public function setUser(\Cac\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cac\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return PromoOffertes
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set nbpersonne
     *
     * @param integer $nbpersonne
     *
     * @return PromoOffertes
     */
    public function setNbpersonne($nbpersonne)
    {
        $this->nbpersonne = $nbpersonne;

        return $this;
    }

    /**
     * Get nbpersonne
     *
     * @return integer
     */
    public function getNbpersonne()
    {
        return $this->nbpersonne;
    }

    /**
     * Set hour
     *
     * @param string $hour
     *
     * @return PromoOffertes
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hour
     *
     * @return string
     */
    public function getHour()
    {
        return $this->hour;
    }
}
