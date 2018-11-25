<?php
// src/OC/UserBundle/Entity/User.php

namespace OC\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="oc_user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
	/**
	* @ORM\Column(name="id", type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	protected $id;

	/**
    * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Advert", mappedBy="user", cascade={"persist","remove"})
    */
	private $adverts;

    /**
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="user", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $applications;

	/**
    * @ORM\Column(name="nb_adverts", type="integer")
    */
    private $nbAdverts;

	public function __construct()
    {
        parent::__construct();
        $this->adverts = new ArrayCollection();
        $this->nbAdverts = 0;
    }

    public function increaseAdvert()
    {
        $this->nbAdverts++;
    }

    public function decreaseAdvert()
    {
        $this->nbAdverts--;
    }

    /**
     * Add advert
     *
     * @param \OC\PlatformBundle\Entity\Advert $advert
     *
     * @return User
     */
    public function addAdvert(\OC\PlatformBundle\Entity\Advert $advert)
    {
        $this->adverts[] = $advert;

        return $this;
    }

    /**
     * Remove advert
     *
     * @param \OC\PlatformBundle\Entity\Advert $advert
     */
    public function removeAdvert(\OC\PlatformBundle\Entity\Advert $advert)
    {
        $this->adverts->removeElement($advert);
    }

    /**
     * Get adverts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdverts()
    {
        return $this->adverts;
    }

    /**
     * Set nbAdverts.
     *
     * @param int $nbAdverts
     *
     * @return User
     */
    public function setNbAdverts($nbAdverts)
    {
        $this->nbAdverts = $nbAdverts;

        return $this;
    }

    /**
     * Get nbAdverts.
     *
     * @return int
     */
    public function getNbAdverts()
    {
        return $this->nbAdverts;
    }

    /**
     * Add application.
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     *
     * @return User
     */
    public function addApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        $this->applications[] = $application;

        return $this;
    }

    /**
     * Remove application.
     *
     * @param \OC\PlatformBundle\Entity\Application $application
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeApplication(\OC\PlatformBundle\Entity\Application $application)
    {
        return $this->applications->removeElement($application);
    }

    /**
     * Get applications.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApplications()
    {
        return $this->applications;
    }
}
