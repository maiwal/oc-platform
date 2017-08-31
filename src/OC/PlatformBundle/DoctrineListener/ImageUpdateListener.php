<?php
// src/OC/PlatformBundle/DoctrineListener/ImageUpdateListener.php

namespace OC\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OC\PlatformBundle\Entity\Image;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageUpdateListener
{
  /**
   * @var \ContainerInterface
   */
  protected $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function postUpdate(LifecycleEventArgs $args)
  {
    $em = $this->container->get('doctrine.orm.entity_manager');
    $entity = $args->getObject();

    if (!$entity instanceof Image) {
      return;
    }

    if ($entity->getImageSize() == 0) {
      $entity->getAdvert()->setImage();
      $em->remove($entity);
      $em->flush();
    }
  }

}
