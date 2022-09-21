<?php

namespace App\Controller\Front;

use App\Repository\Job\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/job', name: 'app_front_job_')]
class JobController extends AbstractController
{
    public function __construct(private JobRepository $jobRepository)
    {
    }

    #[Route('/job', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('front/job/index.html.twig', [
            'controller_name' => 'JobController',
        ]);
    }

    #[Route("/{slug<[a-z0-9\-]+>}-{id<\d+>}", name: 'show', methods: ['GET'])]
    public function show(string $slug, int $id): Response
    {
        $job = $this->jobRepository->findJobWithRelations($id);

        return $this->render('front/job/show.html.twig', compact('job'));
    }
}
