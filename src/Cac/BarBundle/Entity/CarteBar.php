<?php

namespace Cac\BarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * CarteBar
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class CarteBar
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
     * @ORM\ManyToOne(targetEntity="Cac\BarBundle\Entity\Bar", inversedBy="carte")
     */
    protected $bar;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;
    
    /**
    * @ORM\Column(type="boolean")
    */
    public $visible = false;

    /**
     * @Assert\File(
     *      maxSize="6000000",
     *      mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",
     *          "application/pdf",
     *          "application/x-pdf"
     *      },
     *      mimeTypesMessage = "Format de carte non valideF"
     * )
    */
    public $file;

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
     * Constructor
     */
    public function __construct()
    {
        $this->bar = new \Doctrine\Common\Collections\ArrayCollection();
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
        return 'uploads/carte-bar';
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
     * Set path
     *
     * @param string $path
     * @return CarteBar
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
     * Add bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     * @return CarteBar
     */
    public function addBar(\Cac\BarBundle\Entity\Bar $bar)
    {
        $this->bars[] = $bar;

        return $this;
    }

    /**
     * Remove bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     */
    public function removeBar(\Cac\BarBundle\Entity\Bar $bar)
    {
        $this->bars->removeElement($bar);
    }

    /**
     * Get bar
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * Set bar
     *
     * @param \Cac\BarBundle\Entity\Bar $bar
     * @return CarteBar
     */
    public function setBar(\Cac\BarBundle\Entity\Bar $bar = null)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     *
     * @return CarteBar
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
