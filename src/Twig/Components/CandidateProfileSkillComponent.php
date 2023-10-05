<?php

namespace App\Twig\Components;

use App\Controller\BaseController;
use App\Entity\User\Candidate;
use App\Form\User\CandidateSkillFormType;
use App\Repository\User\CandidateSkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveCollectionTrait;

#[AsLiveComponent('candidate_profile_skill')]
class CandidateProfileSkillComponent extends BaseController
{
    use DefaultActionTrait;
    use LiveCollectionTrait;

    #[LiveProp(writable: true)]
    public ?Candidate $candidate = null;

    public function __construct(private CandidateSkillRepository $candidateSkillRepository)
        {}

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(CandidateSkillFormType::class, $this->candidate);
    }

    #[LiveAction()]
    public function save(EntityManagerInterface $manager): RedirectResponse
    {
        $this->submitForm();

        $skills = $this->getForm()->getData();


        $manager->persist($skills);
        $manager->flush();

        $this->addFlash('success', 'ui.alerts.profile_updated');

        return $this->redirectBack('app_front_candidate_dashboard');
    }

    public function getSkills()
    {
        return  $this->candidateSkillRepository->findForCandidate($this->candidate);
    }
}
