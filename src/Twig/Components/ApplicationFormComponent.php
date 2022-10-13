<?php

namespace App\Twig\Components;

use App\Controller\BaseController;
use App\Entity\Job\Application;
use App\Entity\Job\Job;
use App\Event\Job\JobAppliedEvent;
use App\Form\Type\ApplicationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('application_form')]
class ApplicationFormComponent extends BaseController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true, fieldName: 'job_job')]
    public ?Application $application = null;

    #[LiveProp(writable: true, fieldName: 'application_job')]
    public ?Job $job = null;

    public function __construct(private EntityManagerInterface $manager, private EventDispatcherInterface $eventDispatcher, private TokenStorageInterface $tokenStorage)
    {
        $this->application = new Application();
    }

    #[LiveAction]
    public function save()
    {
        $this->submitForm();
        /** @var Application $application */
        $application = $this->getFormInstance()->getData();
        dump($application);
        $application->setJob($this->job)
            ->setStatus(Application::STATUS_PENDING)
            ->setCandidate($this->tokenStorage->getToken()->getUser());

        $this->manager->persist($application);
        $this->manager->flush();
        $this->eventDispatcher->dispatch(new JobAppliedEvent($this->job, $application->getCandidate()));
        $this->addFlash('success', 'ui.alerts.job_applied');
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ApplicationType::class, $this->application);
    }
}