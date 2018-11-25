<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadApplication.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use OC\PlatformBundle\DataFixtures\ORM\LoadUser;
use OC\PlatformBundle\DataFixtures\ORM\LoadAdvert;

use OC\PlatformBundle\Entity\Application;

class LoadApplication extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $listApplications = array(
            array(
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('eula'),
                'advert' => $manager->getRepository('OCPlatformBundle:Advert')->findOneByTitle('Chef de chantier')
            ),
            array(
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('thao'),
                'advert' => $manager->getRepository('OCPlatformBundle:Advert')->findOneByTitle('Conducteur de metro')
            ),
            array(
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('quinn'),
                'advert' => $manager->getRepository('OCPlatformBundle:Advert')->findOneByTitle('Recherche développpeur Symfony')
            ),
            array(
                'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('quinn'),
                'advert' => $manager->getRepository('OCPlatformBundle:Advert')->findOneByTitle('Offre de stage webdesigner')
            )
        );

        foreach ($listApplications as $application) {
            $newApplication = new Application();
            $newApplication->setContent($application['content']);
            $newApplication->setUser($application['user']);
            $newApplication->setAdvert($application['advert']);
            $manager->persist($newApplication);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadUser::class,
            LoadAdvert::class,
        );
    }
}