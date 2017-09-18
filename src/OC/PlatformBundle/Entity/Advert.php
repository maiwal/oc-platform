<?php
// src/OC/PlatformBundle/Entity/Advert.php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Advert
 *
 * @ORM\Table(name="oc_advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Advert
{

    /**
    * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\AdvertSkill", mappedBy="advert", cascade={"persist", "remove"})
    */
    private $skills;

    /**
    * @Gedmo\Slug(fields={"title"})
    * @ORM\Column(name="slug", type="string", length=255, unique=true)
    */
    private $slug;

    /**
    * @ORM\Column(name="nb_applications", type="integer")
    */
    private $nbApplications;

    /**
    * @ORM\Column(name="updated_at", type="datetime", nullable=true)
    */
    private $updatedAt;

    /**
    * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert", cascade={"persist","remove"})
    */
    private $applications;

    /**
    * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
    * @ORM\JoinTable(name="oc_advert_category")
    */
    private $categories;

    /**
    * @var int
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="date", type="datetime")
    * @Assert\DateTime()
    */
    private $date;

    /**
    * @var string
    *
    * @ORM\Column(name="title", type="string", length=255)
    * @Assert\Length(min=10)
    */
    private $title;

    /**
    * @var string
    *
    * @ORM\Column(name="author", type="string", length=255, nullable=true)
    * @Assert\Length(min=2)
    */
    private $author;

    /**
    * @var string
    *
    * @ORM\Column(name="email", type="string", length=255, nullable=true)
    * @Assert\Email(checkMX=true)
    */
    private $email;

    /**
    * @var string
    *
    * @ORM\Column(name="content", type="text",nullable=true)
    * @Assert\NotBlank()
    */
    private $content;

    /**
    *
    * @ORM\Column(name="published", type="boolean")
    */
    private $published;

    private $deleteImage;

    /**
    * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist","remove"}, inversedBy="advert")
    * @ORM\JoinColumn(nullable=true)
    * @Assert\Valid()
    */
    private $image;


    public function __construct()
    {
        $this->date           = new \Datetime();
        $this->published      = false;
        $this->categories     = new ArrayCollection();
        $this->applications   = new ArrayCollection();
        $this->skills         = new ArrayCollection();
        $this->nbApplications = 0;
        $this->deleteImage    = false;
    }

    public function setDeleteImage($deleteImage)
    {
        $this->deleteImage = $deleteImage;
    }

    public function getDeleteImage()
    {
        return $this->deleteImage;
    }

    public function increaseApplication()
    {
        $this->nbApplications++;
    }

    public function decreaseApplication()
    {
        $this->nbApplications--;
    }

    /**
    * @ORM\PreUpdate
    */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
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
    * Set date
    *
    * @param \DateTime $date
    *
    * @return Advert
    */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
    * Get date
    *
    * @return \DateTime
    */
    public function getDate()
    {
        return $this->date;
    }

    /**
    * Set title
    *
    * @param string $title
    *
    * @return Advert
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

    /**
    * Set author
    *
    * @param string $author
    *
    * @return Advert
    */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
    * Get author
    *
    * @return string
    */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
    * Set content
    *
    * @param string $content
    *
    * @return Advert
    */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
    * Get content
    *
    * @return string
    */
    public function getContent()
    {
        return $this->content;
    }


    /**
    * Set published
    *
    * @param boolean $published
    *
    * @return Advert
    */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
    * Get published
    *
    * @return boolean
    */
    public function getPublished()
    {
        return $this->published;
    }

    /**
    * Add category
    *
    * @param \OC\PlatformBundle\Entity\Category $category
    *
    * @return Advert
    */
    public function addCategory(\OC\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;
        return $this;
    }

    /**
    * Remove category
    *
    * @param \OC\PlatformBundle\Entity\Category $category
    */
    public function removeCategory(\OC\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
    * Get categories
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
    * Add application
    *
    * @param \OC\PlatformBundle\Entity\Application $application
    *
    * @return Advert
    */
    public function addApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        $this->applications[] = $application;
        $application->setAdvert($this);
        return $this;
    }

    /**
    * Remove application
    *
    * @param \OC\PlatformBundle\Entity\Application $application
    */
    public function removeApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        $this->applications->removeElement($application);
    }

    /**
    * Get applications
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getApplications()
    {
        return $this->applications;
    }

    /**
    * Set updatedAt
    *
    * @param \DateTime $updatedAt
    *
    * @return Advert
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
    * Set nbApplications
    *
    * @param integer $nbApplications
    *
    * @return Advert
    */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;
        return $this;
    }

    /**
    * Get nbApplications
    *
    * @return integer
    */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

    /**
    * Set email
    *
    * @param string $email
    *
    * @return Advert
    */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
    * Get email
    *
    * @return string
    */
    public function getEmail()
    {
        return $this->email;
    }

    /**
    * Set slug
    *
    * @param string $slug
    *
    * @return Advert
    */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
    * Get slug
    *
    * @return string
    */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
    * Add skill
    *
    * @param \OC\PlatformBundle\Entity\AdvertSkill $skill
    *
    * @return Advert
    */
    public function addSkill(\OC\PlatformBundle\Entity\AdvertSkill $skill)
    {
        $this->skills[] = $skill;
        return $this;
    }

    /**
    * Remove skill
    *
    * @param \OC\PlatformBundle\Entity\AdvertSkill $skill
    */
    public function removeSkill(\OC\PlatformBundle\Entity\AdvertSkill $skill)
    {
        $this->skills->removeElement($skill);
    }

    /**
    * Get skills
    *
    * @return \Doctrine\Common\Collections\Collection
    */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
    * Set image
    *
    * @param \OC\PlatformBundle\Entity\Image $image
    *
    * @return Advert
    */
    public function setImage(\OC\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;
        return $this;
    }

    /**
    * Get image
    *
    * @return \OC\PlatformBundle\Entity\Image
    */
    public function getImage()
    {
        return $this->image;
    }

    /**
    * @Assert\Callback
    */
    public function isContentValid(ExecutionContextInterface $context)
    {
        
        $forbiddenWords = array(
            'connards',
            'connard',
            'enculé',
            'enculés'
        );

        // On vérifie que le contenu ne contient pas l'un des mots
        if (preg_match('#'.implode('|', $forbiddenWords).'#', $this->getContent())) {

            // La règle est violée, on définit l'erreur
            $context
                ->buildViolation('Contenu invalide, grossier personnage...') // message
                ->atPath('content') // attribut de l'objet qui est violé
                ->addViolation() // ceci déclenche l'erreur, ne l'oubliez pas
            ;
        }

    }

}
