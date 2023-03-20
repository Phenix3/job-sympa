<?php

namespace App;

use App\Entity\Setting;
use App\Event\SettingCreatedEvent;
use App\Event\SettingDeletedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class SettingManager
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $eventDispatcher,
        private TagAwareCacheInterface $cache
    ) {}

    public function get(string $keyName, ?string $default = null): ?string
    {
        $setting = $this->entityManager->getRepository(Setting::class)->find($keyName);
        return null === $setting ? $default : $setting->getValue();
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
        if (null === $keys) {
            $settings = $this->entityManager->getRepository(Setting::class)->findAll();
        } else {
            $settings = $this->entityManager->getRepository(Setting::class)->findBy([
                'keyName' => $keys
            ]);
        }

        $settingsByKey = array_reduce($settings, function(array $acc, Setting  $setting) {
            $acc[$setting->getKeyName()] = $setting->getValue();
            return $acc;
        }, []);

        if (null === $keys) {
            return $settingsByKey;
        }

        $settings = array_reduce($keys, function(array $acc, string $key) use ($settingsByKey) {
            $acc[$key] = $settingsByKey[$key] ?? null;
            return $acc;
        }, []);

        return $settings;
    }
}
