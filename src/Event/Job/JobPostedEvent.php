<?php

namespace App\Event\Job;

use App\Entity\Job\Job;

class JobPostedEvent
{
    public function __construct(private Job $job)
    {}

    /**
     * @return Job
     */
    public function getJob(): Job
    {
        return $this->job;
    }
}