<?php

namespace App\Controller\Front;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use App\Repository\CountryRepository;
use App\Entity\Country;

#[Route('/', name: 'app_front_')]
class CountryController extends BaseController
{
	public function __construct(private TagAwareCacheInterface $cache, private CountryRepository $repository)
	{}

	#[Route('/countries-autocomplete', name: 'countries_autocomplete', methods: ['GET'])]
	public function countryAutocomplete(Request $request): JsonResponse
	{
		$countries = $this->cache->get('countries', function(ItemInterface $item) {
			$item->tag('countries_tag');
			return $this->repository->findAll();
		});

		$query = $request->query->get('query', '');
		if (null !== $query && '' !== $query) {
			$countries = array_filter($countries, function(Country $country) use($query) {
				return str_contains(mb_strtolower($country->getName()), mb_strtolower($query));
			});
		}

		$results = [];

		foreach ($countries as $country) {
			$results[] = [
				'value' => $country->getId(),
				'text' => $country->getName(),
			];
		}

		return $this->json(['results' => $results]);
	}
}