<?php
// src/OC/PlatformBundle/Purger/AdvertPurger.php

namespace OC\PlatformBundle\Purger;

use Doctrine\ORM\EntityManager;

class AdvertPurger
{

	/**
	 * @var \EntityManager
	 */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function purge($days)
	{
		
    	$date = new \DateTime('-'.$days.' day');

		$listAdvertsToPurge = $this->em
			->getRepository('OCPlatformBundle:Advert')
	    	->getAdvertToPurge($date)
	  	;

	    foreach ($listAdvertsToPurge as $advertToPurge)
	    	$this->em->remove($advertToPurge);

	    return $this->em->flush();

	}

	public function purgeTotale()
	{

		$listAdvertsToPurge = $this->em
			->getRepository('OCPlatformBundle:Advert')
	    	->findAll()
	  	;

	    foreach ($listAdvertsToPurge as $advertToPurge)
	    	$this->em->remove($advertToPurge);

	    return $this->em->flush();

	}

}