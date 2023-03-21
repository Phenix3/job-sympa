<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use App\Setting\SettingCreatedEvent;

#[AsEventListener(event: SettingCreatedEvent::class, method: 'onSettingCreated')]
class SettingEventListener
{

	public function onSettingCreated(SettingCreatedEvent $event)
	{

	}

}