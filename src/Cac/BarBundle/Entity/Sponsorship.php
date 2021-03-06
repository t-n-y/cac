<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsorship
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Cac\BarBundle\Entity\SponsorshipRepository")
 */
class Sponsorship
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
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="usedAt", type="datetime", nullable=true)
     */
    private $usedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="sponsorships")
     */
    protected $bar;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Restriction")
     */
    protected $restriction;

    public function __construct()
    {
        $this->createdAt = new \Datetime();
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
     * Set code
     *
     * @param string $code
     *
     * @return Sponsorship
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Sponsorship
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

    /**
     * Set usedAt
     *
     * @param \DateTime $usedAt
     *
     * @return Sponsorship
     */
    public function setUsedAt($usedAt)
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    /**
     * Get usedAt
     *
     * @return \DateTime
     */
    public function getUsedAt()
    {
        return $this->usedAt;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     *
     * @return Sponsorship
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
     * Set restriction
     *
     * @param \Cac\BarBundle\Entity\Restriction $bar
     *
     * @return restriction
     */
    public function setRestriction(\Cac\BarBundle\Entity\Restriction $restriction = null)
    {
        $this->restriction = $restriction;

        return $this;
    }

    /**
     * Get restriction
     *
     * @return \Cac\BarBundle\Entity\Restriction
     */
    public function getRestriction()
    {
        return $this->restriction;
    }
}
