<?php

namespace App\Controller\Front\User;

use App\Controller\BaseController;
use App\Entity\Job\Application;
use App\Entity\Job\Job;
use App\Form\JobFormType;
use App\Service\JobService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('employer', name: 'app_front_employer_')]
#[IsGranted('ROLE_EMPLOYER')]
class EmployerController extends BaseController
{
    public function __construct(private EntityManagerInterface $manager)
    {}

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('front/user/employer/dashboard.html.twig');
    }

    #[Route('/post-job', name: 'post_job')]
    public function postJob(Request $request, JobService $jobService): RedirectResponse|Response
    {
        $job = new Job();
        $form = $this->createForm(JobFormType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job->setCompany($this->getUser());
            $jobService->create($job);
            $this->addFlash('success', 'ui.alerts.job_posted');
            return $this->redirectToRoute('app_front_employer_jobs');
        }

        return $this->renderForm('front/user/employer/post_job.html.twig', compact('form'));
    }

    #[Route('/jobs', name: 'jobs', methods: ['GET'])]
    public function jobs(PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('front/user/employer/jobs.html.twig', [
            'jobs' => $paginator->paginate(
                $this->manager->getRepository(Job::class)->findAllForEmployerQuery($this->getUser()),
                $request->query->getInt('page', 1)
            ),
        ]);
    }

    #[Route('/jobs/{slug}/applications', name: 'job_applications', methods: ['GET'])]
    public function applications(Job $job, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('front/user/employer/applications.html.twig', [
            'applications' => $paginator->paginate(
                $this->manager->getRepository(Application::class)->findForJob($job),
                $request->query->getInt('page', 1)
            ),
            'job' => $job
        ]);
    }
}