<?php

namespace App\Controller\Front;

use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use App\Controller\BaseController;
use App\Form\LoginFormType;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use function Symfony\Component\Translation\t;

class SecurityController extends BaseController
{
    #[Route(path: '/login', name: 'app_login')]
    #[Breadcrumb('<i class="fa fa-home"></i>', 'app_home')]
    #[Breadcrumb('ui.login', 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, BasicSeoGenerator $seoGenerator): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);
        $seoGenerator
            ->setTitle(t('ui.titles.sign_in'))
            ->setDescription('')
            ->setKeywords('')
        ;

        if ($this->getUser()) {
            $this->addFlash('warning', 'ui.alerts.already_logged_in');

            return $this->redirectBack('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/security/login.html.twig', [
            'form' => $form,
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
