<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use Carbon\Carbon;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\RequestStack;

class CarbonExtension extends AbstractExtension
{
	public function __construct(private RequestStack $requestStack)
	{}

=======

class CarbonExtension extends AbstractExtension
{
>>>>>>> origin/master
	public function getFilters(): array
	{
		return [
			new TwigFilter('carbon_date', [$this, 'carbonDate'])
		];
	}

	public function carbonDate($date)
	{
<<<<<<< HEAD
		$locale = $this->getLocale();
		$parsed = Carbon::parse($date)->locale($locale);
		return $parsed->diffForHumans();
	}

	private function getLocale()
	{
		$request = $this->requestStack->getCurrentRequest();

		return $request->getPreferredLanguage();
	} 
=======
		$parsed = Carbon::parse($date);
		return $parsed->diffForHumans();
	}
>>>>>>> origin/master
}