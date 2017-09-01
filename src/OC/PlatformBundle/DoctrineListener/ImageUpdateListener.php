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
    $entity = $args->getObject();

    if (!$entity instanceof Image) {
      return;
    }

    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');

    if ($entity->getPreviewName() != null) {
      $liipCacheManager->remove('uploads/images/adverts/'.$entity->getPreviewName());
    }

    $em = $this->container->get('doctrine.orm.entity_manager');

    if ($entity->getImageSize() == 0) {
      $entity->getAdvert()->setImage();
      $em->remove($entity);
      $em->flush();
    }

  }

  public function preRemove(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    if (!$entity instanceof Image) {
      return;
    }

    $liipCacheManager = $this->container->get('liip_imagine.cache.manager');

    if ($entity->getImageName() != null) {
      $liipCacheManager->remove('uploads/images/adverts/'.$entity->getImageName());
    }

  }

}
