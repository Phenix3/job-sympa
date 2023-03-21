<?php

namespace App\Twig\Extension;

use App\SettingManager;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class SettingExtension extends AbstractExtension implements GlobalsInterface
{

    public function __construct(private SettingManager $settingManager)
    {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setting', [$this, 'getSetting'], ['needs_context' => true, 'is_safe' => ['html']]),
        ];
    }

    public function getSetting(array $context, string $keyName, string $default = '')
    {
        $settings = $context['global_settings'];
        return $settings[$keyName] ?: $default;
    }

    public function getGlobals(): array
    {
        return [
            'global_settings' => $this->settingManager->all()
        ];
    }

    
}
