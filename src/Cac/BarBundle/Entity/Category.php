<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToMany(targetEntity="Cac\BarBundle\Entity\Bar", mappedBy="bar")
     */
    protected $bars;

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
     * @return Category
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
     * Constructor
     */
    public function __construct()
    {
        $this->bars = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add bars
     *
     * @param \Cac\BarBundle\Entity\Bar $bars
     * @return Category
     */
    public function addBar(\Cac\BarBundle\Entity\Bar $bars)
    {
        $this->bars[] = $bars;

        return $this;
    }

    /**
     * Remove bars
     *
     * @param \Cac\BarBundle\Entity\Bar $bars
     */
    public function removeBar(\Cac\BarBundle\Entity\Bar $bars)
    {
        $this->bars->removeElement($bars);
    }

    /**
     * Get bars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBars()
    {
        return $this->bars;
    }
}
