<?php

namespace App\Event\Job;

use App\Entity\Job\Application;

class JobAppliedEvent
{
    public function __construct(private Application $application)
    {}

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }
}