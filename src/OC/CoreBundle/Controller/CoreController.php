<?php

namespace OC\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {

        return $this->render('OCCoreBundle:Core:index.html.twig');
    }

    public function contactAction(Request $request)
    {

        $request->getSession()->getFlashBag()->add(
            'info',
            "La page de contact n'est pas encore disponible."
        );

        return $this->redirectToRoute('core_homepage');
        // return $this->render('CoreBundle:Core:contact.html.twig');
          
    }
}
