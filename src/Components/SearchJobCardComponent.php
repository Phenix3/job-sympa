<?php

namespace App\Components;

use App\Entity\Job\Job;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('search_job_card')]
class SearchJobCardComponent
{

    public Job $job;

}