<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Category;
use OC\PlatformBundle\Entity\Skill;
use OC\PlatformBundle\Entity\AdvertSkill;

class LoadAdvert implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {

    // Création de la liste des annonces à ajouter
    $listAdverts = array(
      array(
      'email'    => 'maiwalw@gmail.com',
      'title'    => 'Recherche développpeur Symfony',
      'author'   => 'Alexandre',
      'content'  => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
      'imageUrl' => 'http://o-c-d.fr/bundles/app/img/symfony/symfony_components.jpg'
      ),
      array(
      'title'    => 'Mission de webmaster',
      'author'   => 'Hugo',
      'content'  => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
      'email'    => 'maiwalw@gmail.com',
      'imageUrl' => 'http://www.soundofsymfony.com/images/logo.png'
      ),
      array(
      'title'    => 'Chef de chantier',
      'author'   => 'Marcel',
      'email'    => 'maiwalw@gmail.com',
      'content'  => 'Nous recherchons un chef de chantier. Blabla…',
      'imageUrl' => 'https://it-blog.qarea.com/wp-content/uploads/2014/10/love-symfony.png'
      ),
      array(
      'title'    => 'Conducteur de metro',
      'author'   => 'Hugo',
      'content'  => 'Nous recherchons un conducteur de metro. Blabla…',
      'imageUrl' => 'https://innobyte.com/wp-content/uploads/2014/02/symfony2-novice-to-ninja-300x152.png',
      'email'    => 'maiwalw@gmail.com'
      ),
      array(
      'title'    => 'Offre de stage webdesigner',
      'email'    => 'maiwalw@gmail.com',
      'author'   => 'Mathieu',
      'content'  => 'Nous proposons un poste pour webdesigner. Blabla…',
      'imageUrl' => 'http://www.numerogeek.com/files/large/ec09f0c11d40846821f35f3256c59ee9.jpg'
      )
    );
    /***************************/

    // Création de la liste des catégories
    $nomsCategories = array(
      'Développement web',
      'Développement mobile',
      'Graphisme',
      'Intégration',
      'Enseignement',
      'Manutention',
      'Réseau'
    );
    /***************************/

    // Instanciation des objets Category
    foreach ($nomsCategories as $nomsCategorie) {
      $category = new Category();
      $category->setName($nomsCategorie);
      $listeCategories[] = $category;
    } 
    /***************************/

    // Création de la liste des compétences
    $nomsCompetences = array(
      'PHP',
      'Symfony',
      'C++',
      'Java',
      'Photoshop',
      'Blender',
      'Bloc-note'
    );
    /***************************/
    
    // Instanciation des objets Skill (les compétences)
    foreach ($nomsCompetences as $nomCompetence) {
      $competence = new Skill();
      $competence->setName($nomCompetence);
      $listeCompetences[] = $competence;
    }
    /***************************/

    // Création de la liste des candidatures
    $nomsApplications = array(
      array(
        'author'  => 'Kevin',
        'content' => 'Je suis très motivé, blabla.'
      ),
      array(
        'author'  => 'John',
        'content' => 'Je veux ce poste absolument, blabla.'
      ),
      array(
        'author'  => 'Henry',
        'content' => 'Je suis fait pour ce poste, blabla.'
      ),
      array(
        'author'  => 'Samuel',
        'content' => 'Je suis le plus qualifié pour ce travail, blabla.'
      )
    );
    /***************************/

    foreach ($listAdverts as $advert) {

      // Instanciation de l'objet Image
      $image = new Image();
      $image->setUrl($advert['imageUrl']);
      $image->setAlt($advert['title']);
      /***************************/

      // Instanciation des objets Application (les candidatures)
      $listApplications = array();

      foreach ($nomsApplications as $application) {
        $applicationAEnvoyer = new Application();
        $applicationAEnvoyer->setAuthor($application['author']);
        $applicationAEnvoyer->setContent($application['content']);
        $listApplications[] = $applicationAEnvoyer;
      }
      /***************************/

      // Instanciation de l'objet Advert (l'annonce)
      $AnnonceAEnvoyer = new Advert();
      $AnnonceAEnvoyer->setTitle($advert['title']);
      $AnnonceAEnvoyer->setAuthor($advert['author']);
      $AnnonceAEnvoyer->setContent($advert['content']);
      $AnnonceAEnvoyer->setEmail($advert['email']);
      $AnnonceAEnvoyer->setImage($image);
      /***************************/

      // Liaison des candidatures à l'annonce
      foreach ($listApplications as $application) {
        $AnnonceAEnvoyer->addApplication($application);
      }
      /***************************/

      // Liason des catégories à l'annonce
      foreach ($listeCategories as $category) {
        $AnnonceAEnvoyer->addCategory($category);
      }
      /***************************/

      // Liason des compétences à l'annonce
      foreach ($listeCompetences as $competence) {
        $intermediaireAnnonceCompetence = new AdvertSkill();
        $intermediaireAnnonceCompetence->setSkill($competence);
        $intermediaireAnnonceCompetence->setAdvert($AnnonceAEnvoyer);
        $intermediaireAnnonceCompetence->setLevel('Expert');
        $manager->persist($intermediaireAnnonceCompetence);
      }
      /***************************/

      // Enregistrement Dans l'ORM
      $manager->persist($AnnonceAEnvoyer);
      /***************************/

    }

    //Enregistrement en base de donnée
    $manager->flush();
    /***************************/
  }
}