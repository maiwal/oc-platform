<?php

namespace OC\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController {

    public function loginAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        //redirection si déjà connecté
        // if ( $this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') ) {
        //     return $this->redirectToRoute('oc_platform_home');
        // }

        return parent::loginAction($request);
    }
}