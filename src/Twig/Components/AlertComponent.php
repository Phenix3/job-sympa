<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class AlertComponent
{
    public ?string $type = 'info';

    public ?string $message = null;

    public function getIcon(): string
    {
        return match ($this->type) {
            'success' => 'fa fa-circle-check',
            'danger' => 'fa fa-circle-times',
            'info' => 'fa fa-circle-info',
            'warning' => 'fa fa-circle-exclamation',
        };
    }
}