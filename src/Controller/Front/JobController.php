<?php

namespace App\Controller\Front;

use App\Dto\JobSearchData;
use App\Form\SearchType;
use App\Repository\Job\JobRepository;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @throws NonUniqueResultException
     */
    #[Route("/{slug<[a-z0-9\-]+>}-{id<\d+>}", name: 'show', methods: ['GET'])]
    public function show(string $slug, int $id): Response
    {
        $job = $this->jobRepository->findJobWithRelations($id);

        return $this->render('front/job/show.html.twig', compact('job'));
    }

    #[Route("/search", name: 'search')]
    public function searchJobs(Request $request, PaginatorInterface $paginator, ?JobSearchData $jobSearchData = null): Response
    {
        $form = $this->createForm(SearchType::class, $jobSearchData, [
            'csrf_protection' => false,
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        $jobs = $paginator->paginate(
            $this->jobRepository->searchJobs($jobSearchData),
            (int)$request->get('page', 1)
        );

//        dump($jobSearchData);
        return $this->renderForm('front/job/search.html.twig', compact('jobs', 'form', 'jobSearchData'));
    }
}
