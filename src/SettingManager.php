<?php

namespace App;

use App\Entity\Setting;
use App\Event\SettingCreatedEvent;
use App\Event\SettingDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class SettingManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private TagAwareCacheInterface $cache
    ) {}

    public function get(string $keyName, ?string $default = null): ?string
    {
        $settings = $this->all();
        return $settings[$keyName] ?? $default;
    }

    public function set(string $keyName, string $value)
    {
        $setting = $this->entityManager->getRepository(Setting::class)->find($keyName);
        if (null === $setting) {
            $setting = (new Setting)
                ->setKeyName($keyName)
                ->setValue($value);
            $this->entityManager->persist($setting);
        } else {
            $setting->setValue($value);
        }

        $this->entityManager->flush();
        $this->eventDispatcher->dispatch(new SettingCreatedEvent($setting));
    }

    public function delete(string $keyName): void
    {
        $setting = $this->entityManager->getRepository(Setting::class)->find($keyName);
        if (null !== $setting) {
            $this->entityManager->remove($setting);
        }
        $this->entityManager->flush();
        $this->eventDispatcher->dispatch(new SettingDeletedEvent($setting));
    }

    public function all(?array $keys = null): array
    {
        $settings = $this->cache->get('global_settings', function(ItemInterface $item) use($keys) {
            $item->tag(['global_settings_tag']);
            $settings = $this->entityManager->getRepository(Setting::class)->findAll();

            $settings = array_reduce($settings, function(array $acc, Setting  $setting) {
                $acc[$setting->getKeyName()] = $setting->getValue();
                return $acc;
            }, []);

            return $settings;
        });

        if (null !== $keys) {
            return array_reduce($keys, function(array $acc, string $key) use ($settings) {
                $acc[$key] = $settings[$key] ?? null;
                return $acc;
            }, []);
        }

        return $settings;
    }
}
