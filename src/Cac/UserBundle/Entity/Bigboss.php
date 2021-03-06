<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * Bigboss
 *
 * @ORM\Entity
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\UserBundle\Entity\BigbossRepository")
 * @UniqueEntity(fields = "username", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Bigboss extends User
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
     * @ORM\Column(name="gender", type="string", length=255)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255, nullable=true)
     */
    private $siret;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="author")
     */
    protected $createdBars;

    /**
     * @ORM\OneToMany(targetEntity="Cac\PaymentBundle\Entity\PaymentOptions", mappedBy="user")
     */
    protected $paymentOptions;

    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "10",
     *      max = "10",
     *      minMessage = "Votre numéro doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre numéro ne peut pas être plus long que {{ limit }} caractères",
     *      exactMessage = "Le numéro doit contenir 10 chiffres"
     * )
     * @Assert\Regex(
     *     pattern="#^(06|07)#",
     *     message="Le numéro doit être un numéro de portable valide"
     * )
     * @ORM\Column(name="mobile_phone", type="integer")
     */
    private $mobile_phone;

    /**
     * @var integer
     * @Assert\Length(
     *      min = "10",
     *      max = "10",
     *      minMessage = "Votre numéro doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre numéro ne peut pas être plus long que {{ limit }} caractères",
     *      exactMessage = "Le numéro doit contenir 10 chiffres"
     * )
     * @ORM\Column(name="fix_phone", type="integer", nullable=true)
     */
    private $fix_phone;

    /**
     * @var array
     */
    protected $roles;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    protected $score = 0;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="custom_validation_token", type="string", length=255, nullable=true)
     */
    private $customValidationToken;

    /**
     * @var integer
     *
     * @ORM\Column(name="glass_price", type="integer")
     */
    protected $glassPrice = 25;

     /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdBars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_BIGBOSS');
        $this->isActive = false;
        $this->customValidationToken = substr(str_shuffle(MD5(microtime())), 0, 20);
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

    /**
     * Set gender
     *
     * @param string $gender
     * @return Bigboss
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return BasicUser
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Bigboss
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set customValidationToken
     *
     * @param string $customValidationToken
     *
     * @return Bigboss
     */
    public function setCustomValidationToken($customValidationToken)
    {
        $this->customValidationToken = $customValidationToken;

        return $this;
    }

    /**
     * Get customValidationToken
     *
     * @return string
     */
    public function getCustomValidationToken()
    {
        return $this->customValidationToken;
    }

    /**
     * Set glassPrice
     *
     * @param integer $glassPrice
     *
     * @return Bigboss
     */
    public function setGlassPrice($glassPrice)
    {
        $this->glassPrice = $glassPrice;

        return $this;
    }

    /**
     * Get glassPrice
     *
     * @return integer
     */
    public function getGlassPrice()
    {
        return $this->glassPrice;
    }

    /**
     * Add paymentOption
     *
     * @param \Cac\PaymentBundle\Entity\paymentOptions $paymentOption
     *
     * @return Bigboss
     */
    public function addPaymentOption(\Cac\PaymentBundle\Entity\paymentOptions $paymentOption)
    {
        $this->paymentOptions[] = $paymentOption;

        return $this;
    }

    /**
     * Remove paymentOption
     *
     * @param \Cac\PaymentBundle\Entity\paymentOptions $paymentOption
     */
    public function removePaymentOption(\Cac\PaymentBundle\Entity\paymentOptions $paymentOption)
    {
        $this->paymentOptions->removeElement($paymentOption);
    }

    /**
     * Get paymentOptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentOptions()
    {
        return $this->paymentOptions;
    }
}
