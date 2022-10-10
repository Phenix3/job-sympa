<?php

namespace App\Components;

use App\Entity\Job\Job;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('job_card')]
class JobCardComponent
{

    public Job $job;

}