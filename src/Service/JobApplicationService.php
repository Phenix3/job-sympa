<?php

namespace App\Service;

use App\Entity\Job\Application;
use App\Event\Job\ApplicationDeletedEvent;
use App\Event\Job\JobAppliedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class JobApplicationService
{
    public function __construct(private EntityManagerInterface $manager, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * @param Application $application
     * @return Application
     */
    public function create(Application $application): Application
    {
        $this->manager->getRepository(Application::class)->add($application, true);
        $this->eventDispatcher->dispatch(new JobAppliedEvent($application));
        return $application;
    }

    public function delete(Application $application): Application
    {
        $this->manager->getRepository(Application::class)->remove($application, true);
        $this->eventDispatcher->dispatch(new ApplicationDeletedEvent($application));
        return $application;
    }
}