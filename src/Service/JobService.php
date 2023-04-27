<?php

namespace App\Service;

use App\Entity\Job\Job;
use App\Event\Job\JobPostedEvent;
use App\Repository\Job\JobRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class JobService
{
    public function __construct(private JobRepository $repository, private EventDispatcherInterface $dispatcher)
    {}

    public function create(Job $job): Job
    {
        $this->repository->add($job, true);
        $this->dispatcher->dispatch(new JobPostedEvent($job));
        return $job;
    }

    public function toggleBookmark(int $id, UserInterface $user)
    {
        $job = $this->repository->findJobWithBookmarksQuery($id, $user)->getResult();
        dump($job);
    }

    public function getRelatedJobs(Job $job, ?int $limit = 4)
    {
        return $this->repository->findRelatedJobs($job, $limit);
    }

}
