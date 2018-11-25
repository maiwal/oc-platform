<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\DataFixtures\ORM\LoadUser;

class LoadAdvert extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // Création de la liste des annonces à ajouter
        $listAdverts = array(
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('eula')
            ),
            array(
                'title'     => 'Mission de webmaster',
                'content'   => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('thao')
            ),
            array(
                'title'     => 'Chef de chantier',
                'content'   => 'Nous recherchons un chef de chantier. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('beatris')
            ),
            array(
                'title'     => 'Conducteur de metro',
                'content'   => 'Nous recherchons un conducteur de metro. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('reanna')
            ),
            array(
                'title'     => 'Offre de stage webdesigner',
                'content'   => 'Nous proposons un poste pour webdesigner. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('quinn')
            ),
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('tiffani')
            ),
            array(
                'title'     => 'Mission de webmaster',
                'content'   => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('mariette')
            ),
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('edna')
            ),
            array(
                'title'     => 'Mission de webmaster',
                'content'   => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('nancee')
            ),
            array(
                'title'     => 'Chef de chantier',
                'content'   => 'Nous recherchons un chef de chantier. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('dorthey')
            ),
            array(
                'title'     => 'Conducteur de metro',
                'content'   => 'Nous recherchons un conducteur de metro. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('eula')
            ),
            array(
                'title'     => 'Offre de stage webdesigner',
                'content'   => 'Nous proposons un poste pour webdesigner. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('thao')
            ),
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('beatris')
            ),
            array(
                'title'     => 'Mission de webmaster',
                'content'   => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('reanna')
            ),
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('quinn')
            ),
            array(
                'title'     => 'Mission de webmaster',
                'content'   => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('tiffani')
            ),
            array(
                'title'     => 'Chef de chantier',
                'content'   => 'Nous recherchons un chef de chantier. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('mariette')
            ),
            array(
                'title'     => 'Conducteur de metro',
                'content'   => 'Nous recherchons un conducteur de metro. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('edna')
            ),
            array(
                'title'     => 'Offre de stage webdesigner',
                'content'   => 'Nous proposons un poste pour webdesigner. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('nancee')
            ),
            array(
                'title'     => 'Recherche développpeur Symfony',
                'content'   => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'user' => $manager->getRepository('OCUserBundle:User')->findOneByUsername('dorthey')
            )
        );
        /***************************/

        //date d'aujourd'hui pour toutes les annonces
//        $date = new \Datetime();

        foreach ($listAdverts as $advert) {
            $AnnonceAEnvoyer = new Advert();
            $AnnonceAEnvoyer->setTitle($advert['title']);
            $AnnonceAEnvoyer->setUser($advert['user']);
            $AnnonceAEnvoyer->setContent($advert['content']);
//            $AnnonceAEnvoyer->setDate($date);
            $AnnonceAEnvoyer->setPublished(1);
            $manager->persist($AnnonceAEnvoyer);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadUser::class,
        );
    }
}