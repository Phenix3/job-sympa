<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('active_class', [$this, 'getActiveClass'], [
                'needs_context' => true
            ]),
        ];
    }

    public function getActiveClass(array $context, string $routeName, string $activeClass = 'active'): string
    {
        $request = $context['app']->getRequest();
        return $request->attributes->get('_route') === $routeName ? " {$activeClass} " : "";
    }
}
