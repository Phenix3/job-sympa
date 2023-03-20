<?php
namespace App\EventListener;


use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use App\Event\Country\CountryCreatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use App\Entity\Country;
use Symfony\Contracts\Cache\TagAwareCacheInterface;


#[AsEventListener(event: CountryCreatedEvent::class, method: 'onCountryCreated')]
#[AsEventListener(event: AfterEntityPersistedEvent::class, method: 'onAfterCountryPersisted')]
#[AsEventListener(event: AfterEntityDeletedEvent::class, method: 'onAfterCountryDeleted')]
final class CountryEventListener
{
	public function __construct(private TagAwareCacheInterface $cache)
	{}

	public function onAfterCountryPersisted(AfterEntityPersistedEvent $event)
	{
		$this->invalidateTags($event->getEntityInstance(), ['countries_tag']);
	}

	public function onAfterCountryDeleted(AfterEntityDeletedEvent $event)
	{
		$this->invalidateTags($event->getEntityInstance(), ['countries_tag']);
	}

	public function invalidateTags(object $entity, array $tags)
	{
		if (!($entity instanceof Country)) {
            return;
        }
		$this->cache->invalidateTags($tags);
	}
}