<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * BasicUser
 *
 * @ORM\Entity(repositoryClass="Cac\UserBundle\Entity\BasicUserRepository")
 * @ORM\Table()
 * @UniqueEntity(fields = "username", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Cac\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class BasicUser extends User
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
     *     message="Le numéro doit être un uméro de portable valide"
     * )
     * @ORM\Column(name="mobile_phone", type="integer")
     */
    private $mobile_phone;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255, nullable=true)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var integer
     *
     * @Assert\Type(type="integer", message="Le code postal doit être un chiffre.")
     * @Assert\Length(
     *      min = "5",
     *      max = "5",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères",
     *      exactMessage = "Le code postal doit contenir 5 chiffres"
     * )
     * @ORM\Column(name="zipcode", type="integer", length=255, nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="geocode", type="string", length=255, nullable=true)
     */
    private $geocode;

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
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebookId;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Avis", mappedBy="user")
     */
    protected $avis;

     /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdBars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_USER');
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
     * Set adress
     *
     * @param string $adress
     *
     * @return BasicUser
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set region
     *
     * @param string $region
     *
     * @return BasicUser
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return BasicUser
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return BasicUser
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set zipcode
     *
     * @param integer $zipcode
     *
     * @return BasicUser
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return integer
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set geocode
     *
     * @param string $geocode
     *
     * @return BasicUser
     */
    public function setGeocode($geocode)
    {
        $this->geocode = $geocode;

        return $this;
    }

    /**
     * Get geocode
     *
     * @return string
     */
    public function getGeocode()
    {
        return $this->geocode;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return BasicUser
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
     * @return BasicUser
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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return BasicUser
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Add avi
     *
     * @param \Cac\BarBundle\Entity\Avis $avi
     *
     * @return BasicUser
     */
    public function addAvi(\Cac\BarBundle\Entity\Avis $avi)
    {
        $this->avis[] = $avi;

        return $this;
    }

    /**
     * Remove avi
     *
     * @param \Cac\BarBundle\Entity\Avis $avi
     */
    public function removeAvi(\Cac\BarBundle\Entity\Avis $avi)
    {
        $this->avis->removeElement($avi);
    }

    /**
     * Get avis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvis()
    {
        return $this->avis;
    }
}
