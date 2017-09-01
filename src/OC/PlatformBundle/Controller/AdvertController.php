<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Form\AdvertType;
use OC\PlatformBundle\Form\AdvertEditType;

class AdvertController extends Controller
{

    public function indexAction($page)
    {

      if ($page == '') $page = 1;

      if ($page < 0) {
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
          20 /*limit per page*/
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

      $advert = new Advert();

      $form = $this->createForm(AdvertType::class, $advert);

    	if ($request->isMethod('POST')) {

        $form->handleRequest($request);

        if ($form->isValid()) {

          // $advert->getImage()->setPreviewName();

          $em = $this->getDoctrine()->getManager();
          $em->persist($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add('success', 'Annonce bien enregistrée.');

          return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }

    	}

      return $this->render('OCPlatformBundle:Advert:add.html.twig', array(
        'form' => $form->createView(),
      ));

    }

    public function editAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->find($id)
        ;

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $form = $this->createForm(AdvertEditType::class, $advert);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);

            if ($form->isValid()) {

              $em->flush();

              $request->getSession()->getFlashBag()->add('success', 'Annonce bien modifiée.');

              return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
            } 

        }

        // Permet de se rappeler de l'image pour la supprimer dans le cache
        if ($advert->getImage() != null) {
          $advert->getImage()->setPreviewName();
          $em->flush();
        }

      	return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
          'advert' => $advert,
          'form' => $form->createView()
        ));

    }

    public function deleteAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          $em->remove($advert);
          $em->flush();

          $request->getSession()->getFlashBag()->add(
            'success',
            "L'annonce a bien été supprimée.");

          return $this->redirectToRoute('oc_platform_home');
        }
        
        return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
          'advert' => $advert,
          'form'   => $form->createView(),
        ));

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

    public function categoriesAction($page)
    {

      if ($page == '') $page = 1;

      if ($page < 0) {
        throw new NotFoundHttpException('Page "'.$page.'" inexistante.');
      }

      $pagination = $this->getDoctrine()
        ->getManager()
        ->getRepository('OCPlatformBundle:Category')
        ->getCategories()
      ;

      // Creating pagnination
      $paginator  = $this->get('knp_paginator');
      $listCategories = $paginator->paginate(
          $pagination, /* query NOT result */
          $page, /*page number*/
          20 /*limit per page*/
      );

      $nbOfPage = $listCategories->getPageCount();

      if ($page > $nbOfPage)
        return $this->redirectToRoute('oc_platform_categories', array('page' => $nbOfPage));

      return $this->render('OCPlatformBundle:Advert:categories.html.twig', array(
        'listCategories' => $listCategories
      ));
    }

}

