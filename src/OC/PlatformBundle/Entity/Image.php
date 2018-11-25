<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
     *     maxSize = "2024k",
     *     mimeTypes = {"image/jpeg", "image/png"},
     * )
     *
     * @var File
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

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

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
            $this->updated = new \DateTimeImmutable();

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
        return __dir__ . '/../../../../web/uploads/images';
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getRelativePath()
    {
        return 'uploads/images/' . $this->path;
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
            $this->path = sha1(uniqid(mt_rand(), true)) . '.' . $this->imageFile->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->imageFile !== null) {

            $this->imageFile->move($this->getUploadRootDir(), $this->path);
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

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Image
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Image
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
