<?php
namespace App\Dto;

use Doctrine\Common\Collections\ArrayCollection;

class EmployerSearchData
{

	public ?int $page = 1;

	public ?int $perPage = 12;

	public ?string $name = '';

	public ?string $ceo = '';

	/**
	 * @var array<int>
	 */
	public array|ArrayCollection $categories = [];

    public ?string $country = '';
}
