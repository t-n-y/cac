<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class File
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path = "defaultImageBar.jpg";

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="files")
     */
    protected $bar;

    /**
     * @var integer
     *
     * @ORM\Column(name="sliderOrder", type="integer", nullable=true)
     */
    private $order;

    /**
     * @var integer
     *
     * @ORM\Column(name="cropX", type="integer", nullable=true)
     */
    private $cropX;

    /**
     * @var integer
     *
     * @ORM\Column(name="cropY", type="integer", nullable=true)
     */
    private $cropY;

    /**
     * @var integer
     *
     * @ORM\Column(name="cropW", type="integer", nullable=true)
     */
    private $cropW;

    /**
     * @var integer
     *
     * @ORM\Column(name="cropH", type="integer", nullable=true)
     */
    private $cropH;

    /**
     * @var boolean
     *
     * @ORM\Column(name="slider", type="boolean")
     */
    private $slider = 0;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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

    public function resizeImg($c)
    {
        $thumb = imagecreatetruecolor($c['w']/$c['ratio'], $c['h']/$c['ratio']);
        $source = imagecreatefromjpeg($this->getAbsolutePath());
        list($width, $height) = getimagesize($this->getAbsolutePath());
        $image = imagecopyresized($thumb, $source, 0, 0, $c['x']/$c['ratio'], $c['y']/$c['ratio'], ($c['x2']-$c['x'])/$c['ratio'], ($c['y2']-$c['y'])/$c['ratio'], $c['w']/$c['ratio'], $c['h']/$c['ratio']);  
        imagejpeg($thumb, $this->getAbsolutePath(), 100); 
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
     * Set path
     *
     * @param string $path
     *
     * @return File
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
     * Set order
     *
     * @param integer $order
     *
     * @return File
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set cropX
     *
     * @param integer $cropX
     *
     * @return File
     */
    public function setCropX($cropX)
    {
        $this->cropX = $cropX;

        return $this;
    }

    /**
     * Get cropX
     *
     * @return integer
     */
    public function getCropX()
    {
        return $this->cropX;
    }

    /**
     * Set cropY
     *
     * @param integer $cropY
     *
     * @return File
     */
    public function setCropY($cropY)
    {
        $this->cropY = $cropY;

        return $this;
    }

    /**
     * Get cropY
     *
     * @return integer
     */
    public function getCropY()
    {
        return $this->cropY;
    }

    /**
     * Set cropW
     *
     * @param integer $cropW
     *
     * @return File
     */
    public function setCropW($cropW)
    {
        $this->cropW = $cropW;

        return $this;
    }

    /**
     * Get cropW
     *
     * @return integer
     */
    public function getCropW()
    {
        return $this->cropW;
    }

    /**
     * Set cropH
     *
     * @param integer $cropH
     *
     * @return File
     */
    public function setCropH($cropH)
    {
        $this->cropH = $cropH;

        return $this;
    }

    /**
     * Get cropH
     *
     * @return integer
     */
    public function getCropH()
    {
        return $this->cropH;
    }

    /**
     * Set slider
     *
     * @param boolean $slider
     *
     * @return File
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return boolean
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
