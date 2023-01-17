<?php

namespace App\Controller\Front;

use App\Dto\JobSearchData;
use App\Entity\Job\Application;
use App\Entity\Job\Category;
use App\Entity\Job\Job;
use App\Entity\User\Candidate;
use App\Entity\User\JobBookmark;
use App\Form\SearchType;
use App\Form\Type\ApplicationType;
use App\Repository\Job\JobRepository;
use App\Repository\User\JobBookmarkRepository;
use App\Service\BookmarkService;
use App\Service\JobApplicationService;
use App\Service\JobService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Knp\Component\Pager\PaginatorInterface;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    #[Route('/{id<\d+>}/bookmark', name: 'bookmark')]
    public function toggleBookmark(int $id, JobRepository $jobRepository, Request $request, BookmarkService $bookmarkService)
    {
        $job = $jobRepository->findJobWithBookmarksQuery($id)->getOneOrNullResult();

        if ($this->getUser()) {
            $bookmarked = $bookmarkService->toggleBookmark($this->getUser(), $job);
            // dump($job, count($job->getJobBookmarks()));
            return $this->json([
                'job' => $job,
                'bookmarks' => count($job->getJobBookmarks()),
                'bookmarked' => $bookmarked
            ]);
        } else {
            $data['error'] = 'Unauthorized to perform this action';
            $data['bookmarked'] = false;
            return $this->json($data, 401, []);
        }

        // if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
        //     $frameId = $request->headers->get('Turbo-Frame');
        //     $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
        //     return $this->render('front/job/_bookmarked.stream.html.twig', compact('job', 'frameId'));
        // }
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route("/{slug<[a-z0-9\-]+>}-{id<\d+>}", name: 'show', methods: ['GET', 'POST'])]
    #[Breadcrumb('<i class="fa fa-home"></i>', routeName: 'app_home')]
    #[Breadcrumb('ui.titles.search', routeName: 'app_front_job_index')]
    #[Breadcrumb('{slug}')]
    public function show(string $slug, int $id, Request $request, JobApplicationService $applicationService): Response
    {
        $data = [];
        $job = $this->jobRepository->findJobWithRelations($id);
        $data['job'] = $job;

        if ($this->isGranted('JOB_CAN_APPLY', $job)) {
            $application = new Application();
            $application
                ->setJob($job)
                ->setStatus(Application::STATUS_PENDING)
            ;
            $applicationForm = $this->createForm(ApplicationType::class, $application);
            $applicationForm->handleRequest($request);
            $data['applicationForm'] = $applicationForm->createView();
            if ($applicationForm->isSubmitted() && $applicationForm->isValid()) {
                $this->denyAccessUnlessGranted('JOB_CAN_APPLY', $job);
                $application->setCandidate($this->getUser());
                $applicationService->create($application);
                if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                    $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                    return $this->render('front/job/_applied.stream.html.twig');
                }
            }
        }

        dump($data);

        return $this->render('front/job/show.html.twig', $data);
    }

    #[Route("/search", name: 'search')]
    #[Breadcrumb('<i class="fa fa-home"></i>', routeName: 'app_home')]
    #[Breadcrumb('ui.titles.search')]
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
