<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use function Symfony\Component\Translation\t;

#[Route('/admin', name: 'admin_')]
class SecurityController extends AbstractController
{

	#[Route('/login', name: 'login')]
	public function login(AuthenticationUtils $authenticationUtils, BasicSeoGenerator $seoGenerator): Response
	{
		$seoGenerator
            ->setTitle(t("ui.titles.sign_in"))
            ->setDescription("")
            ->setKeywords("")
            ;

         if ($this->getUser()) {
            $this->addFlash('warning', 'ui.alerts.already_logged_in');
            return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $data = [
        	'last_username' => $authenticationUtils->getLastUsername(),
        	'error' => $authenticationUtils->getLastAuthenticationError(),
        	'username_parameter' => 'email',
        	'password_parameter' => 'password',
        	'csrf_token_intention' => 'authenticate'
        ];

        return $this->render('@EasyAdmin/page/login.html.twig', $data);
	}

	#[Route('/logout', name: 'logout')]
	public function logout()
	{

	}
}