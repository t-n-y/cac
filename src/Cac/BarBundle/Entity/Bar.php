<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\BarRepository")
 */
class Bar
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="editedAt", type="datetime", nullable=true)
     */
    private $editedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @ORM\Column(name="schedule", type="text", nullable=true)
     */
    private $schedule;

    /**
     * @var string
     *
     * @ORM\Column(name="access", type="text", nullable=true)
     */
    private $access;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\UserBundle\Entity\Bigboss", inversedBy="createdBars")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Cac\BarBundle\Entity\Category", inversedBy="bars")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $categories;

    /**
     * @var integer
     *
     * @ORM\Column(name="priceRange", type="integer", nullable=true)
     */
    private $priceRange;

    /**
     * @var integer
     *
     * @ORM\Column(name="dressCode", type="integer", nullable=true)
     */
    private $dressCode;

    /**
     * @var boolean
     *
     * @ORM\Column(name="valet", type="boolean", nullable=true)
     */
    private $valet;

    /**
     * @var integer
     *
     * @ORM\Column(name="valetCost", type="integer", nullable=true)
     */
    private $valetCost;

    /**
     * @var boolean
     *
     * @ORM\Column(name="handicappedAccess", type="boolean", nullable=true)
     */
    private $handicappedAccess;

    /**
     * @var boolean
     *
     * @ORM\Column(name="patio", type="boolean", nullable=true)
     */
    private $patio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="smokingArea", type="boolean", nullable=true)
     */
    private $smokingArea;

    /**
     * @var boolean
     *
     * @ORM\Column(name="breathalyser", type="boolean", nullable=true)
     */
    private $breathalyser;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Comment", mappedBy="bar")
     */
    private $comments;

    /**
     * @ORM\OneToOne(targetEntity="Cac\BarBundle\Entity\Promotion", mappedBy="bar")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity="Cac\UserBundle\Entity\Barman", mappedBy="bar")
     */
    protected $barman;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Image", mappedBy="bar")
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->bigboss = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creationDate = new \Datetime();
        $this->barman = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Bar
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
     * Set adress
     *
     * @param string $adress
     * @return Bar
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
     * Set town
     *
     * @param string $town
     * @return Bar
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
     * @return Bar
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Bar
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set editedAt
     *
     * @param \DateTime $editedAt
     * @return Bar
     */
    public function setEditedAt($editedAt)
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * Get editedAt
     *
     * @return \DateTime 
     */
    public function getEditedAt()
    {
        return $this->editedAt;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Bar
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set schedule
     *
     * @param string $schedule
     * @return Bar
     */
    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

        return $this;
    }

    /**
     * Get schedule
     *
     * @return string 
     */
    public function getSchedule()
    {
        return $this->schedule;
    }

    /**
     * Get schedule
     *
     * @return array 
     */
    public function getScheduleArray()
    {
        return json_decode($this->schedule, true);
    }

    /**
     * Set access
     *
     * @param string $access
     * @return Bar
     */
    public function setAccess($access)
    {
        $this->access = $access;

        return $this;
    }

    /**
     * Get access
     *
     * @return string 
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * Set author
     *
     * @param \Cac\UserBundle\Entity\Bigboss $author
     * @return Bar
     */
    public function setAuthor(\Cac\UserBundle\Entity\Bigboss $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Cac\UserBundle\Entity\Bigboss 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add categories
     *
     * @param \Cac\BarBundle\Entity\Category $categories
     * @return Bar
     */
    public function addCategory(\Cac\BarBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Cac\BarBundle\Entity\Category $categories
     */
    public function removeCategory(\Cac\BarBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set priceRange
     *
     * @param integer $priceRange
     * @return Bar
     */
    public function setPriceRange($priceRange)
    {
        $this->priceRange = $priceRange;

        return $this;
    }

    /**
     * Get priceRange
     *
     * @return integer 
     */
    public function getPriceRange()
    {
        return $this->priceRange;
    }

    /**
     * Set dressCode
     *
     * @param integer $dressCode
     * @return Bar
     */
    public function setDressCode($dressCode)
    {
        $this->dressCode = $dressCode;

        return $this;
    }

    /**
     * Get dressCode
     *
     * @return integer 
     */
    public function getDressCode()
    {
        return $this->dressCode;
    }

    /**
     * Set valet
     *
     * @param boolean $valet
     * @return Bar
     */
    public function setValet($valet)
    {
        $this->valet = $valet;

        return $this;
    }

    /**
     * Get valet
     *
     * @return boolean 
     */
    public function getValet()
    {
        return $this->valet;
    }

    /**
     * Set valetCost
     *
     * @param integer $valetCost
     * @return Bar
     */
    public function setValetCost($valetCost)
    {
        $this->valetCost = $valetCost;

        return $this;
    }

    /**
     * Get valetCost
     *
     * @return integer 
     */
    public function getValetCost()
    {
        return $this->valetCost;
    }

    /**
     * Set handicappedAccess
     *
     * @param boolean $handicappedAccess
     * @return Bar
     */
    public function setHandicappedAccess($handicappedAccess)
    {
        $this->handicappedAccess = $handicappedAccess;

        return $this;
    }

    /**
     * Get handicappedAccess
     *
     * @return boolean 
     */
    public function getHandicappedAccess()
    {
        return $this->handicappedAccess;
    }

    /**
     * Set patio
     *
     * @param boolean $patio
     * @return Bar
     */
    public function setPatio($patio)
    {
        $this->patio = $patio;

        return $this;
    }

    /**
     * Get patio
     *
     * @return boolean 
     */
    public function getPatio()
    {
        return $this->patio;
    }

    /**
     * Set smokingArea
     *
     * @param boolean $smokingArea
     * @return Bar
     */
    public function setSmokingArea($smokingArea)
    {
        $this->smokingArea = $smokingArea;

        return $this;
    }

    /**
     * Get smokingArea
     *
     * @return boolean 
     */
    public function getSmokingArea()
    {
        return $this->smokingArea;
    }

    /**
     * Set breathalyser
     *
     * @param boolean $breathalyser
     * @return Bar
     */
    public function setBreathalyser($breathalyser)
    {
        $this->breathalyser = $breathalyser;

        return $this;
    }

    /**
     * Get breathalyser
     *
     * @return boolean 
     */
    public function getBreathalyser()
    {
        return $this->breathalyser;
    }

    /**
     * Add comments
     *
     * @param \Cac\BarBundle\Entity\Comment $comments
     * @return Bar
     */
    public function addComment(\Cac\BarBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Cac\BarBundle\Entity\Comment $comments
     */
    public function removeComment(\Cac\BarBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set promotion
     *
     * @param \Cac\BarBundle\Entity\Promotion $promotion
     * @return Bar
     */
    public function setPromotion(\Cac\BarBundle\Entity\Promotion $promotion = null)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return \Cac\BarBundle\Entity\Promotion 
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Add barman
     *
     * @param \Cac\UserBundle\Entity\Barman $barman
     * @return Bar
     */
    public function addBarman(\Cac\UserBundle\Entity\Barman $barman)
    {
        $this->barman[] = $barman;

        return $this;
    }

    /**
     * Remove barman
     *
     * @param \Cac\UserBundle\Entity\Barman $barman
     */
    public function removeBarman(\Cac\UserBundle\Entity\Barman $barman)
    {
        $this->barman->removeElement($barman);
    }

    /**
     * Get barman
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBarman()
    {
        return $this->barman;
    }

    /**
     * Add images
     *
     * @param \Cac\BarBundle\Entity\Image $images
     * @return Bar
     */
    public function addImage(\Cac\BarBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Cac\BarBundle\Entity\Image $images
     */
    public function removeImage(\Cac\BarBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Bar
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
