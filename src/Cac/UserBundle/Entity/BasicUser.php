<?php

namespace Cac\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;

/**
 * BasicUser
 *
 * @ORM\Entity
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
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "10",
     *      max = "10",
     *      minMessage = "Votre numéro doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre numéro ne peut pas être plus long que {{ limit }} caractères",
     *      exactMessage = "Le numéro doit contenir 10 chiffres"
     * )
     * @ORM\Column(name="fix_phone", type="integer")
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
    protected $score;

     /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->createdBars = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = array('ROLE_USER');
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
}
