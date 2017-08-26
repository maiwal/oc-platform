<?php
// src/OC/PlatformBundle/Email/ApplicationMailer.php

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;

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

  public function sendNewNotification(Application $application)
  {
    // $message = new \Swift_Message(
    //   'Nouvelle candidature',
    //   'Vous avez reçu une nouvelle candidature.'
    // );
    // $message
    //   ->addTo($application->getAdvert()->getEmail())
    //   ->addFrom('maiwalw@gmail.com')
    // ;
    // $this->mailer->send($message);

    /*mail ( 
      $application->getAdvert()->getEmail(),
      'Nouvelle candidature', 
      'Vous avez reçu une nouvelle candidature.'
    );*/

  }
}
