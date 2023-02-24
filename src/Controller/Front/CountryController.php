<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_front_')]
class CountryController extends BaseController
{
	#[Route('/countries-autocomplete', name: 'countries_autocomplete', methods: ['GET'])]
	public function countryAutocomplete(Request $request): JsonResponse
	{
		$countries = Countries::getNames();
		dump($countries);
		$query = $request->query->get('query', '');
		if (null !== $query && '' !== $query) {
			$countries = array_filter($countries, function($country) use($query) {
				return str_contains(mb_strtolower($country), mb_strtolower($query));
			});
		}

		$results = [];

		foreach ($countries as $alpha2Code => $name) {
			$results[] = [
				'value' => $name,
				'text' => $name,
			];
		}

		return $this->json(['results' => $results]);
	}
}