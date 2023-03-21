<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use App\Setting\SettingCreatedEvent;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[AsEventListener(event: SettingCreatedEvent::class, method: 'onSettingCreated')]
class SettingEventListener
{
	public function __construct(private TagAwareCacheInterface $cache)
	{}

	public function onSettingCreated(SettingCreatedEvent $event)
	{
		$setting = $event->getSetting();
		$this->cache->get('global_settings.' . $setting->getKeyName(), function(ItemInterface $item) use($setting) {
			$item->tag(['global_settings_tag']);
			return $setting;
		});
	}

}