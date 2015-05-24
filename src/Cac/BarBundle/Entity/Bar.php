<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Bar
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\BarRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="town", type="string", length=255)
     */
    private $town;

    /**
     * @var string
     *
     * @Assert\NotBlank()
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
     * @var integer
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer", message="Le code postal doit être un chiffre.")
     * @Assert\Length(
     *      min = "5",
     *      max = "5",
     *      minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre nom ne peut pas être plus long que {{ limit }} caractères",
     *      exactMessage = "Le code postal doit contenir 5 chiffres"
     * )
     * @ORM\Column(name="zipcode", type="integer", length=255)
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
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\CarteBar", mappedBy="bar")
     * @ORM\JoinColumn(name="carte_id", referencedColumnName="id")
     */
    protected $carte;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Highlight", mappedBy="bar")
     * @ORM\JoinColumn(name="highlight_id", referencedColumnName="id")
     */
    protected $highlight;

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
     * @var boolean
     *
     * @ORM\Column(name="babyfoot", type="boolean", nullable=true)
     */
    private $babyfoot;

    /**
     * @var boolean
     *
     * @ORM\Column(name="billard", type="boolean", nullable=true)
     */
    private $billard;

    /**
     * @var boolean
     *
     * @ORM\Column(name="flipper", type="boolean", nullable=true)
     */
    private $flipper;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canape", type="boolean", nullable=true)
     */
    private $canape;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Comment", mappedBy="bar")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\Promotion", mappedBy="bar")
     */
    private $promotions;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\DaySchedule", mappedBy="bar", cascade={"persist"})
     */
    private $daySchedules;

    /**
     * @ORM\OneToMany(targetEntity="Cac\UserBundle\Entity\Barman", mappedBy="bar")
     */
    protected $barman;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity="Cac\BarBundle\Entity\PromoOffertes", mappedBy="bar")
     */
    private $PromoOffertes;

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
        $this->promotions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->daySchdules = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/bar';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // faites ce que vous voulez pour générer un nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // s'il y a une erreur lors du déplacement du fichier, une exception
        // va automatiquement être lancée par la méthode move(). Cela va empêcher
        // proprement l'entité d'être persistée dans la base de données si
        // erreur il y a
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Set babyfoot
     *
     * @param boolean $babyfoot
     * @return Bar
     */
    public function setBabyfoot($babyfoot)
    {
        $this->babyfoot = $babyfoot;

        return $this;
    }

    /**
     * Get babyfoot
     *
     * @return boolean 
     */
    public function getBabyfoot()
    {
        return $this->babyfoot;
    }

    /**
     * Set billard
     *
     * @param boolean $billard
     * @return Bar
     */
    public function setBillard($billard)
    {
        $this->billard = $billard;

        return $this;
    }

    /**
     * Get billard
     *
     * @return boolean 
     */
    public function getBillard()
    {
        return $this->billard;
    }

    /**
     * Set flipper
     *
     * @param boolean $flipper
     * @return Bar
     */
    public function setFlipper($flipper)
    {
        $this->flipper = $flipper;

        return $this;
    }

    /**
     * Get flipper
     *
     * @return boolean 
     */
    public function getFlipper()
    {
        return $this->flipper;
    }

    /**
     * Set canape
     *
     * @param boolean $canape
     * @return Bar
     */
    public function setCanape($canape)
    {
        $this->canape = $canape;

        return $this;
    }

    /**
     * Get canape
     *
     * @return boolean 
     */
    public function getCanape()
    {
        return $this->canape;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Bar
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
     * Set path
     *
     * @param string $path
     * @return Bar
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Bar
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
     * Set PromoOffertes
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $PromoOffertes
     * @return Bar
     */
    public function setPromoOffertes(\Cac\BarBundle\Entity\PromoOffertes $PromoOffertes = null)
    {
        $this->PromoOffertes = $PromoOffertes;

        return $this;
    }

    /**
     * Get PromoOffertes
     *
     * @return \Cac\BarBundle\Entity\PromoOffertes 
     */
    public function getPromoOffertes()
    {
        return $this->PromoOffertes;
    }

    /**
     * Add PromoOffertes
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $PromoOffertes
     * @return Bar
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
     * Add carte
     *
     * @param \Cac\BarBundle\Entity\CarteBar $carte
     *
     * @return Bar
     */
    public function addCarte(\Cac\BarBundle\Entity\CarteBar $carte)
    {
        $this->carte[] = $carte;

        return $this;
    }

    /**
     * Remove carte
     *
     * @param \Cac\BarBundle\Entity\CarteBar $carte
     */
    public function removeCarte(\Cac\BarBundle\Entity\CarteBar $carte)
    {
        $this->carte->removeElement($carte);
    }

    /**
     * Get carte
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarte()
    {
        return $this->carte;
    }

    /**
     * Add highlight
     *
     * @param \Cac\BarBundle\Entity\Highlight $highlight
     *
     * @return Bar
     */
    public function addHighlight(\Cac\BarBundle\Entity\Highlight $highlight)
    {
        $this->highlight[] = $highlight;

        return $this;
    }

    /**
     * Remove highlight
     *
     * @param \Cac\BarBundle\Entity\Highlight $highlight
     */
    public function removeHighlight(\Cac\BarBundle\Entity\Highlight $highlight)
    {
        $this->highlight->removeElement($highlight);
    }

    /**
     * Get highlight
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHighlight()
    {
        return $this->highlight;
    }

    /**
     * Add promotion
     *
     * @param \Cac\BarBundle\Entity\Promotion $promotion
     *
     * @return Bar
     */
    public function addPromotion(\Cac\BarBundle\Entity\Promotion $promotion)
    {
        $this->promotions[] = $promotion;

        return $this;
    }

    /**
     * Remove promotion
     *
     * @param \Cac\BarBundle\Entity\Promotion $promotion
     */
    public function removePromotion(\Cac\BarBundle\Entity\Promotion $promotion)
    {
        $this->promotions->removeElement($promotion);
    }

    /**
     * Get promotions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * Add promoOfferte
     *
     * @param \Cac\BarBundle\Entity\PromoOffertes $promoOfferte
     *
     * @return Bar
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

    /**
     * Add daySchedule
     *
     * @param \Cac\BarBundle\Entity\DaySchedule $daySchedule
     *
     * @return Bar
     */
    public function addDaySchedule(\Cac\BarBundle\Entity\DaySchedule $daySchedule)
    {
        $this->daySchedules[] = $daySchedule;

        return $this;
    }

    /**
     * Remove daySchedule
     *
     * @param \Cac\BarBundle\Entity\DaySchedule $daySchedule
     */
    public function removeDaySchedule(\Cac\BarBundle\Entity\DaySchedule $daySchedule)
    {
        $this->daySchedules->removeElement($daySchedule);
    }

    /**
     * Get daySchedules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDaySchedules()
    {
        return $this->daySchedules;
    }

    /**
     * Update daySchedules
     *
     * @param string
     *
     * @return Bar
     */
    public function updateDaySchedules(\Cac\BarBundle\Entity\DaySchedule $newDaySchedule)
    {
        foreach($this->getDaySchedules() as $daySchedule) {
            if($daySchedule->getDayName() == $newDaySchedule->getDayName()) {
                $daySchedule = $newDaySchedule;
            }
        }
        return $this;
    }

    /**
     *
     * @return \Cac\BarBundle\Entity\DaySchedule or false if not found
     */
    public function getDaySchedule($day)
    {
        foreach($this->getDaySchedules() as $daySchedule) {
            if($daySchedule->getDayName() == $day) return $daySchedule;
        }
        return false;
    }
}
