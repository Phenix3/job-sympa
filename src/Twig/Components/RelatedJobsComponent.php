<?php

namespace App\Twig\Components;

use App\Entity\Job\Job;
use App\Service\JobService;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('related_jobs')]
class RelatedJobsComponent
{
    public Job $job;

    public function __construct(private JobService $jobService)
    {}

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getRelatedJobs()
    {
        // dump($this->job);
        return $this->jobService->getRelatedJobs($this->job, 4);
    }
}