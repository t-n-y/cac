<?php

namespace Cac\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Visited
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\AdminBundle\Entity\VisitedRepository")
 */
class Visited
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
     * @ORM\ManyToOne(targetEntity="Cac\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar")
     * @ORM\JoinColumn(name="bar_id", referencedColumnName="id")
     */
    private $bar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;
    

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
     * Set user
     *
     * @param \Cac\UserBundle\Entity\User $user
     * @return Visited
     */
    public function setUser(\Cac\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Cac\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     * @return Visited
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

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Visited
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
