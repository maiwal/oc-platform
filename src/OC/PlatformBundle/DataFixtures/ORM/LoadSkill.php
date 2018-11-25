<?php
// src/OC/UserBundle/DataFixtures/ORM/LoadSkill.php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use OC\PlatformBundle\Entity\Skill;

class LoadSkill extends Fixture
{

    public function load(ObjectManager $manager)
    {

        // Création de la liste des compétences à ajouter
        $listskills = array(
            'PHP',
            'Symfony',
            'C++',
            'Java',
            'Photoshop',
            'Illustrator'
        );

        // création des entités skill
        foreach ($listskills as $skillName) {
            $skill = new Skill();
            $skill->setName($skillName);
            $manager->persist($skill);
        }
        $manager->flush();
    }

}