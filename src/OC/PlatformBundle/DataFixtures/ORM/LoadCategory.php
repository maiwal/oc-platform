<?php
// src/OC/UserBundle/DataFixtures/ORM/LoadCategory.php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;

class LoadCategory extends Fixture
{

    public function load(ObjectManager $manager)
    {

        // Création de la liste des catérories à ajouter
        $listCategories = array(
            'Réseau',
            'Enseignement',
            'Manutention',
            'Intégration',
            'Graphisme',
            'Développement mobile',
            'Développement web',
            'Développeur PHP',
            'Spécialiste Symfony'
        );

        // création des entités catégory
        foreach ($listCategories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();
    }

}