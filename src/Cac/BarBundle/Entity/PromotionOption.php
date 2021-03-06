<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromotionOption
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PromotionOption
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
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\PromotionOptionCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="category_shortcode", type="string", length=255)
     */
    private $categoryShortcode;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    public function __toString()
    {
        return $this->getName();
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
     * Set value
     *
     * @param integer $value
     *
     * @return PromotionOption
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PromotionOption
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
     * Set categoryShortcode
     *
     * @param string $categoryShortcode
     *
     * @return PromotionOption
     */
    public function setCategoryShortcode($categoryShortcode)
    {
        $this->categoryShortcode = $categoryShortcode;

        return $this;
    }

    /**
     * Get categoryShortcode
     *
     * @return string
     */
    public function getCategoryShortcode()
    {
        return $this->categoryShortcode;
    }

    /**
     * Set category
     *
     * @param \Cac\BarBundle\Entity\PromotionOptionCategory $category
     *
     * @return PromotionOption
     */
    public function setCategory(\Cac\BarBundle\Entity\PromotionOptionCategory $category)
    {
        $this->category = $category;
        $this->setCategoryShortcode($category->getShortcode());

        return $this;
    }

    /**
     * Get category
     *
     * @return \Cac\BarBundle\Entity\PromotionOptionCategory
     */
    public function getCategory()
    {
        return $this->category;
    }
}
