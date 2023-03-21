<?php

namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class JobSearchData
{
    public ?int $page = 1;

    public ?string $query = '';

    public array|ArrayCollection $categories = [];

    public array|ArrayCollection $types = [];

    public ?string $location = '';

<<<<<<< HEAD
    /**
     * @var array<string, string>
     */
=======
>>>>>>> origin/master
    public array|ArrayCollection $country = [];

    public ?string $sort = '';

    public ?string $direction = '';
}