<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Manager
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\ManagerRepository")
 */
class Manager extends BaseUser
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
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="bar")
     */
    protected $createdBars;

    /**
     * @ORM\ManyToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="bar")
     */
    protected $managedBars;


    public function __construct()
    {
        $this->createdBars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->managedBars = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Manager
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
     * @return Manager
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
     * @return Manager
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
     * @return Manager
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
     * Add createdBars
     *
     * @param \Cac\BarBundle\Entity\Bar $createdBars
     * @return Manager
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
     * @return Manager
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
}
