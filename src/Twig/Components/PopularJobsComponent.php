<?php

namespace App\Twig\Components;

use App\Repository\Job\JobRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('popular_jobs')]
class PopularJobsComponent
{
    public function __construct(private JobRepository $jobRepository)
    {}


    public function getJobs()
    {
        return $this->jobRepository->getPopularJobs();
    }
}