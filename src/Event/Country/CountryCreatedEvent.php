<?php
namespace App\Event\Country;

use App\Entity\Country;

class CountryCreatedEvent
{
	public function __construct(private Country $country)
	{}

	public function getCountry()
	{
		return $this->country;
	}
}