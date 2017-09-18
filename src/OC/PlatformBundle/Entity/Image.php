<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
// use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Image
 *
 * @ORM\Table(name="oc_image")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Advert", mappedBy="image")
    */
    private $advert;

    /**
    * @Assert\File(
    *     maxSize = "1024k",
    *     mimeTypes = {"image/jpeg", "image/png"},
    * )
    */
    private $imageFile;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    *
    * @var string
    */
    private $alt;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    *
    * @var string
    */
    private $title;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    *
    * @var string
    */
    private $path;

    public function __construct()
    {

        //construct

    }

    /**
    * @ORM\Column(type="datetime")
    *
    * @var \DateTime
    */
    private $updatedAt;

    /**
    * Set path
    *
    * @param string $path
    *
    * @return Image
    */
    public function setPath($path = null)
    {
        $this->path = $path;
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setImageFile(File $image = null)
    {

        $this->imageFile = $image;

        if ($image)
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
    * @return File|null
    */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
    * @param string $alt
    *
    * @return Product
    */
    public function setAlt($alt = null)
    {
        $this->alt = $alt;
        return $this;
    }

    /**
    * @return string|null
    */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
    * Get id
    *
    * @return int
    */
    public function getId()
    {
        return $this->id;
    }

    /**
    * Set updatedAt
    *
    * @param \DateTime $updatedAt
    *
    * @return Image
    */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
    * Get updatedAt
    *
    * @return \DateTime
    */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
    * Set advert
    *
    * @param \OC\PlatformBundle\Entity\Advert $advert
    *
    * @return Image
    */
    public function setAdvert(\OC\PlatformBundle\Entity\Advert $advert = null)
    {
        $this->advert = $advert;
        return $this;
    }

    /**
    * Get advert
    *
    * @return \OC\PlatformBundle\Entity\Advert
    */
    public function getAdvert()
    {
        return $this->advert;
    }

    /**
    * Set title
    *
    * @param string $title
    *
    * @return Image
    */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
    * Get title
    *
    * @return string
    */
    public function getTitle()
    {
        return $this->title;
    }

    /*********************************/
    /***Gestion de l'upload***********/
    /*********************************/

    public function getUploadRootDir()
    {
        return __dir__.'/../../../../web/uploads/images';
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getRelativePath() {
        return 'uploads/images/'.$this->path;
    }

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {

        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getRelativePath();

        if ($this->imageFile !== null)
            $this->path = sha1(uniqid(mt_rand(),true)).'.'.$this->imageFile->guessExtension();

    }

    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {

        if ($this->imageFile !== null) {

            $this->imageFile->move($this->getUploadRootDir(),$this->path);
            unset($this->imageFile);

            if ($this->oldFile !== null && $this->tempFile !== null)
                unlink($this->tempFile);
        }

    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload()
    {
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
    * @ORM\PostRemove()
    */
    public function removeUpload()
    {

        if (file_exists($this->tempFile))
            unlink($this->tempFile);
        
    }
  
}
