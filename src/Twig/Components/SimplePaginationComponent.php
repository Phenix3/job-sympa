<?php
namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\PostMount;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('simple_pagination')]
class SimplePaginationComponent
{
	use DefaultActionTrait;

	#[LiveProp(writable: true, exposed: ['paginationData[pageCount]', 'paginationData[pageCount]', 'paginationData[previous]', 'paginationData[next]', 'route', 'query', 'paginationData[pageParameterName]', 'paginationData[size]', 'paginationData[align]'])]
	public object $paginable;


	#[LiveAction]
	public function next()
	{

	}
}