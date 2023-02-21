<?php

namespace App\Controller\Front\User;

use App\Controller\BaseController;
use App\Entity\Job\Application;
use App\Entity\Job\Job;
use App\Entity\User\CandidateCvs;
use App\Entity\User\JobBookmark;
use App\Form\User\CandidateAccountFormType;
use App\Form\User\CandidateResumeFormType;
use App\Service\BookmarkService;
use App\Service\JobApplicationService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ChangePasswordFormType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use APY\BreadcrumbTrailBundle\Annotation\Breadcrumb;

#[Route('/candidate', name: 'app_front_candidate_')]
#[IsGranted('ROLE_CANDIDATE')]
class CandidateController extends BaseController {

    /**
     * @param BasicSeoGenerator $seoGenerator
     * @param EntityManagerInterface $manager
     */
    public function __construct(
            private BasicSeoGenerator $seoGenerator,
            private EntityManagerInterface $manager
    ) {
        
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response {
        $this->seoGenerator
                ->setTitle('ui.titles.candidate_dashboard')
                ->setDescription('ui.descriptions.candidate_dashboard')
                ->setKeywords('')
        ;

        return $this->render('front/user/candidate/index.html.twig', [
                    'controller_name' => 'CandidateController',
        ]);
    }

    #[Route("/profile", name: 'profile')]
    public function profile(Request $request, EntityManagerInterface $manager): Response {
        // dump($this->container->get('security.token_storage')->getToken());
        $user = $this->getUser();
        $userAccountForm = $this->createForm(CandidateAccountFormType::class, $user);
        $userAccountForm->handleRequest($request);

        if ($userAccountForm->isSubmitted() && $userAccountForm->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'ui.alerts.');
            return $this->redirectToRoute('app_front_candidate_dashboard');
        }

        return $this->renderForm('front/user/candidate/profile.html.twig', [
                    'user' => $user,
                    'userAccountForm' => $userAccountForm
        ]);
    }

    #[Route("/change-password", name: 'change_password')]
    #[Breadcrumb('Dashboard', routeName: 'app_front_candidate_dashboard')]
    #[Breadcrumb('<i class="fa fa-lock"></i>', routeName: 'app_front_candidate_change_password')]
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

        return $this->renderForm('front/user/change_password.html.twig', compact('form'));
    }

    #[Route('/manage-resume', name: 'manage_resume', methods: ['GET', 'POST'])]
    public function manageResume(Request $request, EntityManagerInterface $manager): Response {
        $resume = new CandidateCvs();
        $resumeForm = $this->createForm(CandidateResumeFormType::class, $resume);
        $resumeForm->handleRequest($request);

        if ($resumeForm->isSubmitted() && $resumeForm->isValid()) {

            $manager->persist($resume);
            $manager->flush();

            $this->addFlash('success', 'ui.alerts.resume_created');
            return $this->redirectToRoute('app_front_candidate_manage_resume');
        }

        return $this->renderForm('front/user/candidate/manage_resume.html.twig', [
                    'resumes' => $this->manager->getRepository(CandidateCvs::class)->findForCandidateQuery($this->getUser())->getResult(),
                    'resumeForm' => $resumeForm
        ]);
    }

    #[Route('/resume/{id}/delete', name: 'resume_delete', methods: ['DELETE', 'POST'])]
    public function deleteResume(CandidateCvs $candidateCvs, Request $request, EntityManagerInterface $manager): RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $candidateCvs->getId(), $request->request->get('_token'))) {
            $manager->remove($candidateCvs);
            $manager->flush();
        }

        $this->addFlash('danger', 'ui.alerts.resume_deleted');

        return $this->redirectToRoute('app_front_candidate_manage_resume');
    }

    #[Route("/applications", name: 'applications', methods: ['GET'])]
    public function applications(PaginatorInterface $paginator, Request $request): Response {
        $applications = $paginator->paginate(
                $this->manager->getRepository(Application::class)->findForCandidate($this->getUser()),
                $request->query->getInt('page', 1)
        );

        return $this->render('front/user/candidate/applications.html.twig', compact('applications'));
    }

    #[Route('/applications/{id}', name: 'application_delete', methods: ['DELETE', 'POST'])]
    public function deleteApplication(Application $application, Request $request, JobApplicationService $applicationService): RedirectResponse {
        if ($this->isCsrfTokenValid('delete' . $application->getId(), $request->request->get('_token'))) {
            $applicationService->delete($application);
        }

        $this->addFlash('danger', 'ui.alerts.application_deleted');
        return $this->redirectToRoute('app_front_candidate_applications');
    }


    #[Route('/job-bookmarks', name: 'job_bookmarks')]
    public function jobBookmarks(BookmarkService $bookmarkService)
    {
        $bookmarks = $bookmarkService->getJobBookmarks($this->getUser())->getResult();
        return $this->render('front/user/candidate/bookmarks.html.twig', compact('bookmarks'));
    }

    #[Route('/{slug<[a-z0-9\-]+>}-{id<\d+>}/toogle-job-bookmark', name: 'toogle_job_bookmark')]
    public function toggleJobBookmark(string $slug, int $id, BookmarkService $bookmarkService)
    {
        $jobBookmark = new JobBookmark();
        $jobBookmark->setUser(
            $this->getUser()
        ) 
        ;
    }

}
