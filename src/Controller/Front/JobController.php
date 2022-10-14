<?php

namespace App\Controller\Front;

use App\Dto\JobSearchData;
use App\Entity\Job\Application;
use App\Entity\Job\Category;
use App\Entity\Job\Job;
use App\Form\SearchType;
use App\Form\Type\ApplicationType;
use App\Repository\Job\JobRepository;
use App\Service\JobApplicationService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/job', name: 'app_front_job_')]
class JobController extends AbstractController
{
    public function __construct(private JobRepository $jobRepository, private BasicSeoGenerator $seoGenerator)
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
    #[Route("/{slug<[a-z0-9\-]+>}-{id<\d+>}", name: 'show', methods: ['GET', 'POST'])]
    public function show(string $slug, int $id, Request $request, JobApplicationService $applicationService): Response
    {
        $job = $this->jobRepository->findJobWithRelations($id);
        $application = new Application();
        $application
            ->setJob($job)
            ->setCandidate($this->getUser())
            ->setStatus(Application::STATUS_PENDING)
            ;
        $applicationForm = $this->createForm(ApplicationType::class, $application);
        $applicationForm->handleRequest($request);
        if ($applicationForm->isSubmitted() && $applicationForm->isValid()) {
            $this->denyAccessUnlessGranted('ROLE_USER');
            $applicationService->create($application);
            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                return $this->render('front/job/_applied.stream.html.twig');
            }
        }
        return $this->renderForm('front/job/show.html.twig', [
            'job' => $job,
            'applicationForm' => $applicationForm
        ]);
    }

    #[Route("/search", name: 'search')]
    public function searchJobs(Request $request, PaginatorInterface $paginator, ?JobSearchData $jobSearchData = null): Response
    {
        $this->seoGenerator
            ->setTitle("")
            ->setDescription("")
            ->setKeywords("")
        ;
        // $jobSearchData = $jobSearchData ?: new JobSearchData();
        return $this->render('front/job/search.html.twig', compact('jobSearchData'));
    }

    #[Route("/category/{id}", name: 'category')]
    public function category(Category $category): Response
    {
        $jobSearchData = new JobSearchData();
        $jobSearchData->categories = [$category->getId()];
        return $this->forward('App\Controller\Front\JobController::searchJobs', [$jobSearchData]);
    }

    #[Route('/{id}/apply', name: 'apply')]
    public function apply(Job $job, EntityManagerInterface $manager): Response
    {
        $application = (new Application())
            ->setJob($job)
            ->setCandidate($this->getUser())
        ;

        $manager->persist($application);
        $manager->flush();

        $this->addFlash('success', 'ui.alerts.application_posted');
        return $this->redirectToRoute('app_front_candidate_dashboard');
    }
}
