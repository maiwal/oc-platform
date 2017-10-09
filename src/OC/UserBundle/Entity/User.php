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
}
