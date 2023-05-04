<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

use function Symfony\Component\Translation\t;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    #[Route(path: '/login', name: 'app_login')]
    #[Breadcrumb('<i class="fa fa-home"></i>', 'app_home')]
    #[Breadcrumb("ui.login", 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, BasicSeoGenerator $seoGenerator): Response
    {
        $seoGenerator
            ->setTitle(t("ui.titles.sign_in"))
            ->setDescription("")
            ->setKeywords("")
            ;

         if ($this->getUser()) {
            $this->addFlash('warning', 'ui.alerts.already_logged_in');
            return $this->redirectBack('app_home');
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
