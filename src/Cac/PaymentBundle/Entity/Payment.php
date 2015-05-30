<?php

namespace Cac\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Payment
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
    * @ORM\OneToOne(targetEntity="Cac\UserBundle\Entity\User", cascade={"persist"})
    */
    private $user;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customer_id", type="string", length=520)
     */
    private $customerId;

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=520)
     */
    private $plan;

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
     *
     * @return Payment
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
     * Set customerId
     *
     * @param string $customerId
     *
     * @return Payment
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set plan
     *
     * @param string $plan
     *
     * @return Payment
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * Get plan
     *
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }
}
