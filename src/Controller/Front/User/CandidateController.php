<?php

namespace App\Controller\Front\User;

use App\Entity\User\CandidateCvs;
use App\Form\User\CandidateResumeFormType;
use App\Repository\User\CandidateCvsRepository;
use App\Repository\User\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Leogout\Bundle\SeoBundle\Seo\Basic\BasicSeoGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function __construct(
        private CandidateRepository $candidateRepository,
        private BasicSeoGenerator $seoGenerator,
        private CandidateCvsRepository $candidateCvsRepository
    ) {
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

    #[Route('/manage-resume', name: 'manage_resume', methods: ['GET', 'POST'])]
    public function manageResume(Request $request, EntityManagerInterface $manager): Response
    {
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
            'resumes' => $this->candidateCvsRepository->findForCandidateQuery($this->getUser())->getResult(),
            'resumeForm' => $resumeForm
        ]);
    }

    #[Route('resume/{id}/delete', name: 'delete_resume')]
    public function deleteResume(CandidateCvs $candidateCvs, Request $request, EntityManagerInterface $manager): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete'.$candidateCvs->getId(), $request->request->get('_token'))) {
            $manager->remove($candidateCvs);
            $manager->flush();
        }

        $this->addFlash('danger', 'ui.alerts.resume_deleted');

        return $this->redirectToRoute('app_front_candidate_manage_resume');
    }
}
