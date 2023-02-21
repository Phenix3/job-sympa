<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use function Symfony\Component\Translation\t;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
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

        return $this->render('front/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
