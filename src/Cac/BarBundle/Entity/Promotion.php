<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Promotion
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
     * @ORM\Column(name="day", type="string", length=255)
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Cac\BarBundle\Entity\PromotionOption", cascade={"persist"})
     */
    protected $options;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="promotions")
     */
    protected $bar;


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
     * Set day
     *
     * @param string $day
     *
     * @return Promotion
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return Promotion
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add option
     *
     * @param \Cac\BarBundle\Entity\PromotionOption $option
     *
     * @return Promotion
     */
    public function addOption(\Cac\BarBundle\Entity\PromotionOption $option)
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * Remove option
     *
     * @param \Cac\BarBundle\Entity\PromotionOption $option
     */
    public function removeOption(\Cac\BarBundle\Entity\PromotionOption $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get only one option depending on the category
     * Used to prevent numerous attributes and allows differenciation between cac promotions and happy hours
     * without having to use 2 entities or nullable true
     *
     * @return \Cac\BarBundle\Entity\PromotionOption or false if not found
     */
    public function getOption($category)
    {
        foreach($this->getOptions() as $option) {
            if($option->getCategoryShortcode() == $category) return $option;
        }
        return false;
    }

    /**
     * Update an option depending on its category
     * Prevent duplicate options with same category
     *
     * @return \Cac\BarBundle\Entity\PromotionOption or false if not found
     */
    public function updateOption(\Cac\BarBundle\Entity\PromotionOption $newOption)
    {
        foreach($this->getOptions() as $option) {
            if($option->getCategoryShortcode() == $newOption->getCategoryShortcode()) {
                $option = $newOption;
            }
        }
        return $this;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     *
     * @return Promotion
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
}
