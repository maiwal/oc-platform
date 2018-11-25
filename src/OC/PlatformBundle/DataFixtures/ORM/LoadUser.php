<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadAdvert.php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use OC\UserBundle\Entity\User;

class LoadUser extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de la liste des utilisateurs à ajouter
        $listUsers = array(
            array(
                'username' => 'eula',
                'email' => 'eula@eula',
            ),
            array(
                'username' => 'thao',
                'email' => 'thao@thao',
            ),
            array(
                'username' => 'beatris',
                'email' => 'beatris@beatris',
            ),
            array(
                'username' => 'reanna',
                'email' => 'reanna@reanna',
            ),
            array(
                'username' => 'quinn',
                'email' => 'quinn@quinn',
            ),
            array(
                'username' => 'tiffani',
                'email' => 'tiffani@tiffani',
            ),
            array(
                'username' => 'mariette',
                'email' => 'mariette@mariette',
            ),
            array(
                'username' => 'edna',
                'email' => 'edna@edna',
            ),
            array(
                'username' => 'nancee',
                'email' => 'nancee@nancee',
            ),
            array(
                'username' => 'dorthey',
                'email' => 'dorthey@dorthey',
            )
        );

        foreach ($listUsers as $user) {
            $newUser = new User();
            $newUser->setEnabled(1);
            $newUser->setEmail($user['email']);
            $newUser->setUsername($user['username']);
            $newUser->setPlainPassword('password');
            $manager->persist($newUser);
        }
        $manager->flush();
    }
}