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

    public function indexAction()
    {

      $em = $this->getDoctrine()->getManager();

      $listAdverts = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->findBy(array(), array('id' => 'desc'))
      ;

      $listApplicationsWithAdvert = $em
        ->getRepository('OCPlatformBundle:Application')
        ->getApplicationsWithAdvert(3)
      ;

    	return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
    		'listAdverts' => $listAdverts,
        'listApplicationsWithAdvert' => $listApplicationsWithAdvert
    	));
    }

    public function viewAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em
          ->getRepository('OCPlatformBundle:Advert')
          ->find($id)
        ;

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // On récupère maintenant la liste des AdvertSkill
        $listAdvertSkills = $em
          ->getRepository('OCPlatformBundle:AdvertSkill')
          ->findBy(array('advert' => $advert))
        ;

        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
          'advert'           => $advert,
          'listAdvertSkills' => $listAdvertSkills
        ));
    }

    public function addAction(Request $request)
    {

    	if ($request->isMethod('POST')) {

    		$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
    		
    		return $this->redirectToRoute('oc_platform_view', array('id' => 5));
    	}

      $em = $this->getDoctrine()->getManager();

      $advert = new Advert();
      $advert->setTitle("Annonce Test");
      $advert->setAuthor("Auteur Test");
      $advert->setContent("Content Test");
      $advert->setEmail('maiwalw@gmail.com');

      $application = new Application();
      $application->setAdvert($advert);
      $application->setAuthor('test');
      $application->setContent('test');

      $em->persist($advert);
      $em->persist($application);

      $em->flush();

      // return $this->redirectToRoute('oc_platform_home');
      return $this->render('OCPlatformBundle:Advert:add.html.twig');
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

      $advert->setTitle("Test changement de titre");

      $em->flush();

    	return $this->render('OCPlatformBundle:Advert:edit.html.twig');
      // return $this->redirectToRoute('oc_platform_home');
    }

    public function deleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        /*$applicationMailer = $this->get('oc_platform.email.application_mailer');

        foreach ($advert->getApplications() as $application) {
          $applicationMailer->sendNewNotification($application);
          // $em->remove($application);
          break;
        }

        $em->flush();*/

    	return $this->render(
        'OCPlatformBundle:Advert:delete.html.twig',
        array('advert' => $advert)
      );
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

}

