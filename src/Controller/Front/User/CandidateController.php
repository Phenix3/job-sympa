<?php

namespace App\Controller\Front\User;

use App\Repository\User\CandidateRepository;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate', name: 'app_front_candidate_')]
#[IsGranted('ROLE_CANDIDATE')]
class CandidateController extends AbstractController
{
    /**
     * @param CandidateRepository $candidateRepository
     * @param BasicSeoGenerator $seoGenerator
     */
    public function __construct(private CandidateRepository $candidateRepository, private BasicSeoGenerator $seoGenerator)
    {
    }

    #[Route('/dashboard', name: 'dashboard')]
    #[IsGranted('ROLE_CANDIDATE')]
    public function dashboard(): Response
    {
        return $this->render('front/user/candidate/index.html.twig', [
            'controller_name' => 'CandidateController',
        ]);
    }

    #[Route("/profile", name: 'profile')]
    public function profile(Request $request): Response
    {
        return $this->renderForm('front/user/candidate/profile.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
