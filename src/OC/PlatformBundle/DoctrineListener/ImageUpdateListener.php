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

  public function preUpdate(LifecycleEventArgs $args)
  {
    
    $entity = $args->getObject();

    if (!$entity instanceof Image) {
      return;
    }

    if ($entity->advert->getDeleteImage())
      return;

    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');

    if ($entity->oldFile != null) {
      $liipCacheManager->remove($entity->oldFile);
    }

  }

  public function preRemove(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    if (!$entity instanceof Image) {
      return;
    }

    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');

    if ($entity->getPath() != null) {
      $liipCacheManager->remove($entity->getPath());
    }

  }

}
