<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Bigboss
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\BigbossRepository")
 */
class Bigboss extends BaseUser
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255)
     */
    private $siret;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="author")
     */
    protected $createdBars;

    /**
     * @ORM\ManyToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="Bigboss")
     */
    protected $managedBars;

    /**
     * @var integer
     * @ORM\Column(name="mobile_phone", type="integer")
     */
    private $mobile_phone;

    /**
     * @var integer
     * @ORM\Column(name="fix_phone", type="integer")
     */
    private $fix_phone;

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
     * Set name
     *
     * @param string $name
     * @return Bigboss
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Bigboss
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set company
     *
     * @param string $company
     * @return Bigboss
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string 
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set siret
     *
     * @param string $siret
     * @return Bigboss
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdBars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managedBars = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add createdBars
     *
     * @param \Cac\BarBundle\Entity\Bar $createdBars
     * @return Bigboss
     */
    public function addCreatedBar(\Cac\BarBundle\Entity\Bar $createdBars)
    {
        $this->createdBars[] = $createdBars;

        return $this;
    }

    /**
     * Remove createdBars
     *
     * @param \Cac\BarBundle\Entity\Bar $createdBars
     */
    public function removeCreatedBar(\Cac\BarBundle\Entity\Bar $createdBars)
    {
        $this->createdBars->removeElement($createdBars);
    }

    /**
     * Get createdBars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCreatedBars()
    {
        return $this->createdBars;
    }

    /**
     * Add managedBars
     *
     * @param \Cac\BarBundle\Entity\Bar $managedBars
     * @return Bigboss
     */
    public function addManagedBar(\Cac\BarBundle\Entity\Bar $managedBars)
    {
        $this->managedBars[] = $managedBars;

        return $this;
    }

    /**
     * Remove managedBars
     *
     * @param \Cac\BarBundle\Entity\Bar $managedBars
     */
    public function removeManagedBar(\Cac\BarBundle\Entity\Bar $managedBars)
    {
        $this->managedBars->removeElement($managedBars);
    }

    /**
     * Get managedBars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getManagedBars()
    {
        return $this->managedBars;
    }

    /**
     * Set mobile_phone
     *
     * @param integer $mobilePhone
     * @return Bigboss
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobile_phone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobile_phone
     *
     * @return integer 
     */
    public function getMobilePhone()
    {
        return $this->mobile_phone;
    }

    /**
     * Set fix_phone
     *
     * @param integer $fixPhone
     * @return Bigboss
     */
    public function setFixPhone($fixPhone)
    {
        $this->fix_phone = $fixPhone;

        return $this;
    }

    /**
     * Get fix_phone
     *
     * @return integer 
     */
    public function getFixPhone()
    {
        return $this->fix_phone;
    }
}