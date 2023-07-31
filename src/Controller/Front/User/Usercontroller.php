<?php

namespace App\Controller\Front\User;

use App\Controller\BaseController;
use App\Form\ChangePasswordFormType;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/user', name: 'app_front_user_')]
#[IsGranted('ROLE_USER')]
class UserController extends BaseController
{

    #[Route("/change-password", name: 'change_password')]
    #[Breadcrumb('Dashboard', routeName: 'app_front_candidate_dashboard')]
    #[Breadcrumb('<i class="fa fa-lock"></i>', routeName: 'app_front_user_change_password')]
    public function changePassword(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher)
    {
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $hash = $passwordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'ui.alerts.password_changed');
            return $this->redirectToRoute('app_front_candidate_dashboard');
        }

        return $this->render('front/user/change_password.html.twig', compact('form'));
    }

}
