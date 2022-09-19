<?php

namespace App\Controller\Front\Candidate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate/dashboard', name: 'app_front_candidate_dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('front/candidate/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
