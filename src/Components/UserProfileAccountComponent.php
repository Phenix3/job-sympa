<?php

namespace App\Components;

use App\Entity\User\Candidate;
use App\Entity\User\User;
use App\Form\Type\UserAccountType;
use App\Form\User\CandidateAccountFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('user_profile_account')]
class UserProfileAccountComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true, fieldName: 'user_profile_account')]
    public ?User $user = null;

    protected function instantiateForm(): FormInterface
    {
        if ($this->user instanceof Candidate) {
            $form = $this->createForm(CandidateAccountFormType::class, $this->user);
        } else {
            $form = $this->createForm(UserAccountType::class, $this->user);
        }

        return $form;
    }

    #[LiveAction()]
    public function save(EntityManagerInterface $manager): RedirectResponse
    {
        $this->submitForm();

        $user = $this->getFormInstance()->getData();

        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'ui.alerts.profile_updated');

        return $this->redirectToRoute('app_front_candidate_dashboard');
    }
}