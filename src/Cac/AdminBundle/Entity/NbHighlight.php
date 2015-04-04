<?php

namespace Cac\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NbHighlight
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NbHighlight
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
     * @var integer
     *
     * @ORM\Column(name="nbHighlight", type="integer")
     */
    private $nbHighlight;

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
     * Set nbHighlight
     *
     * @param integer $nbHighlight
     * @return NbHighlight
     */
    public function setNbHighlight($nbHighlight)
    {
        $this->nbHighlight = $nbHighlight;

        return $this;
    }

    /**
     * Get nbHighlight
     *
     * @return integer 
     */
    public function getNbHighlight()
    {
        return $this->nbHighlight;
    }
}
