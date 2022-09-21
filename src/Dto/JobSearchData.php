<?php

namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class JobSearchData
{
    public ?string $query = '';

    public ?ArrayCollection $categories = null;

    public ?array $type = [];
}