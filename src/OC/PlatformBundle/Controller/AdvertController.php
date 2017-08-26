<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;

class AdvertController extends Controller
{

    public function indexAction($page)
    {

      if ($page == '') $page = 1;

      if ($page < 1) {
        throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
      }

      $pagination = $this->getDoctrine()
        ->getManager()
        ->getRepository('OCPlatformBundle:Advert')
        ->getAdverts()
      ;

      // Creating pagnination
      $paginator  = $this->get('knp_paginator');
      $listAdverts = $paginator->paginate(
          $pagination, /* query NOT result */
          $page, /*page number*/
          10 /*limit per page*/
      );

      $nbOfPage = $listAdverts->getPageCount();

      if ($page > $nbOfPage)
        return $this->redirectToRoute('oc_platform_home', array('page' => $nbOfPage));

      return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
        'listAdverts' => $listAdverts
      ));
    }

    public function viewAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->getAdvert($id)
        ;

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
          'advert' => $advert
        ));
    }

    public function addAction(Request $request)
    {

    	if ($request->isMethod('POST')) {

    		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
    		
    		return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    	}

      $request->getSession()->getFlashBag()->add(
        'info',
        "Il n'est pas encore possible d'ajouter une nouvelle annonce."
      );

      return $this->redirectToRoute('oc_platform_home');
      // return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }

    public function editAction($advert_id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->find($advert_id)
        ;

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$advert_id." n'existe pas.");
        }

      	if ($request->isMethod('POST')) {

      		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
      		
      		return $this->redirectToRoute('oc_platform_view', array('id' => $advert_id));
      	}

        $request->getSession()->getFlashBag()->add(
          'info',
          "Il n'est pas encore possible de modifier les annonces."
        );

        return $this->redirectToRoute('oc_platform_view', array('id' => $advert_id));
    	// return $this->render('OCPlatformBundle:Advert:edit.html.twig');
    }

    public function deleteAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $request->getSession()->getFlashBag()->add(
          'info',
          "Il n'est pas encore possible de supprimer les annonces."
        );

        return $this->redirectToRoute('oc_platform_view', array('id' => $id));

    }

  	public function menuAction($limit)
 	  {
    	
      $em = $this->getDoctrine()->getManager();

      $listAdverts = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->findBy(array(), array('id' => 'desc'), $limit)
      ;

   	 	return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
      		'listAdverts' => $listAdverts
    	));
  	}

    public function purgeAction($days, Request $request)
    {

      if ($days < 1)
          throw new NotFoundHttpException("Veuillez saisir au moins 1 jours");

      $this->get('oc_platform.purger.advert')->purge($days);
      
      $request->getSession()->getFlashBag()->add(
        'success',
        "La purge a bien été effectué sur les annonces n'ayant pas été modifié depuis plus de ".$days." jours."
      );
      
      return $this->redirectToRoute('oc_platform_home');
    }

}

