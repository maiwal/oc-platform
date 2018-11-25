<?php
// src/OC/PlatformBundle/Email/ApplicationMailer.php

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;
use OC\UserBundle\Entity\User;

class ApplicationMailer
{
    /**
    * @var \Swift_Mailer
    */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

//    public function sendNewNotification(Application $application, User $currentUser)
    public function sendNewNotification(Application $application)
    {
        /*$message = new \Swift_Message(
          'Nouvelle candidature',
          'Vous avez reçu une nouvelle candidature.'
        );
        $message
          ->addTo($application->getAdvert()->getUser()->getEmail())
          ->addFrom($currentUser->getEmail())
        ;
        $this->mailer->send($message);*/

        /*mail ( 
        $application->getAdvert()->getEmail(),
        'Nouvelle candidature', 
        'Vous avez reçu une nouvelle candidature.'
        );*/
    }
}
