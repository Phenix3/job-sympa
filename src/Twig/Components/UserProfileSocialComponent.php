<?php

namespace App\Twig\Components;

use App\Entity\User\User;
use App\Form\Type\UserSocialType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('user_profile_social')]
class UserProfileSocialComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    use ComponentToolsTrait;

    #[LiveProp(writable: true, fieldName: 'user_profile_social')]
    public ?User $user = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(UserSocialType::class, $this->user);
    }

    #[LiveAction()]
    public function save(EntityManagerInterface $manager): RedirectResponse
    {
        $this->dispatchBrowserEvent('t:beforeSubmit');

        $this->submitForm();

        $user = $this->getForm()->getData();
        dump($user);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash('success', 'ui.alerts.profile_updated');

        return $this->redirectToRoute('app_front_candidate_dashboard');
    }
}
