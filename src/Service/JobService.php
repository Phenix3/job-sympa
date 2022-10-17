<?php

namespace App\Service;

use App\Entity\Job\Job;
use App\Event\Job\JobPostedEvent;
use App\Repository\Job\JobRepository;
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
}