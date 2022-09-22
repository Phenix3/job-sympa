<?php

namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class JobSearchData
{
    public ?int $page = 1;

    public ?string $query = '';

    public array|ArrayCollection $categories = [];

    public ?array $type = [];

    public ?string $location = '';
}