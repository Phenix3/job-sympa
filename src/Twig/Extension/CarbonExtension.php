<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Carbon\Carbon;

class CarbonExtension extends AbstractExtension
{
	public function getFilters(): array
	{
		return [
			new TwigFilter('carbon_date', [$this, 'carbonDate'])
		];
	}

	public function carbonDate($date)
	{
		$parsed = Carbon::parse($date);
		return $parsed->diffForHumans();
	}
}