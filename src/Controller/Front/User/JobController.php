<?php

namespace App\Controller\Front\User;

use App\Controller\BaseController;
use App\Entity\Job\Job;
use App\Form\JobFormType;
use App\Service\JobService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('user', name: 'app_front_user_job_')]
#[IsGranted('ROLE_EMPLOYER')]
class JobController extends BaseController
{
    #[Route("/{id}/delete", name: 'delete', methods: ['DELETE', 'POST'])]
    public function deleteJob(Job $job, Request $request, JobService $jobService)
    {
        if($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            try {
                $jobService->delete($job);
                $this->addFlash('success', 'alerts.job_deleted');
            } catch (\Throwable $th) {
                $this->addFlash('danger', 'alerts.job_delete_error');
                return throw $th;
            }

            return $this->redirectBack('app_front_employer_jobs');
        }

        return $this->redirectBack('app_front_employer_jobs');
    }

    #[Route('/new', name: 'new')]
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

        return $this->render('front/user/employer/post_job.html.twig', compact('form'));
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST', 'PUT'])]
    public function edit(Job $job, Request $request, JobService $jobService): RedirectResponse|Response
    {
        $this->getSeoGenerator()
            ->setTitle('Edit job '.$job->getTitle())
            ->setDescription('')
            ;

        $form = $this->createForm(JobFormType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job->setCompany($this->getUser());
            $jobService->create($job);
            $this->addFlash('success', 'ui.alerts.job_posted');
            return $this->redirectToRoute('app_front_employer_jobs');
        }

        return $this->render('front/user/employer/post_job.html.twig', compact('form'));
    }

}
