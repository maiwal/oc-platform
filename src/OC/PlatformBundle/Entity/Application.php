<?php
// src/OC/PlatformBundle/Entity/Application.php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Table(name="oc_application")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{

    /**
    * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Advert", inversedBy="applications")
    * @ORM\JoinColumn(nullable=false)
    */
    private $advert;

    /**
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User", inversedBy="applications")
    */
    private $user;

    /**
    * @ORM\Column(name="content", type="text")
    */
    private $content;

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

    public function __construct()
    {
        
    }

    /**
    * @ORM\PrePersist
    */
    public function increase()
    {
        $this->getAdvert()->increaseApplication();
    }

    /**
    * @ORM\PreRemove
    */
    public function decrease()
    {
        $this->getAdvert()->decreaseApplication();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
    * Set advert
    *
    * @param \OC\PlatformBundle\Entity\Advert $advert
    *
    * @return Application
    */
    public function setAdvert(\OC\PlatformBundle\Entity\Advert $advert)
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
     * Set user.
     *
     * @param \OC\UserBundle\Entity\User|null $user
     *
     * @return Application
     */
    public function setUser(\OC\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \OC\UserBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Application
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
     * @return Application
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
