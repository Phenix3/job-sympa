<?php

namespace App\Twig\Components;

use App\Entity\Job\Job;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent("job_card_horizontal")]
class JobCardHorizontalComponent
{
    public Job $job;
}