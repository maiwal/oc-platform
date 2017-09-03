<?php
// src/OC/PlatformBundle/DoctrineListener/AdvertUpdateListener.php

namespace OC\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdvertUpdateListener
{
  /**
   * @var \ContainerInterface
   */
  protected $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function preUpdate(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    if (!$entity instanceof Advert) {
      return;
    }

    if ($entity->getDeleteImage() && $entity->getImage() !== null) {
      $em = $this->container->get('doctrine.orm.entity_manager');
      $em->remove($entity->getImage());
      $entity->setImage();
      $entity->setDeleteImage(false);
    }

  }

}
