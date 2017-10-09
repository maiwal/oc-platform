<?php

namespace OC\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;

use Symfony\Component\HttpFoundation\Request;

class ProfileController extends BaseController
{
   public function deleteAction(Request $request)
   {
   		$userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($this->get('security.token_storage')->getToken()->getUser());

        $request
          ->getSession()
          ->getFlashBag()
          ->add('success', "T'es mort !")
        ;

        return $this->redirectToRoute('fos_user_security_login');
   }
}