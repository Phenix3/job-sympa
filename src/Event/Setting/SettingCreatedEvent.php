<?php

namespace App\Event\Setting;

use App\Entity\Setting;

class SettingCreatedEvent
{
    public function __construct(private Setting $setting){}
    
    public function getSetting(): Setting
    {
        return $this->setting;
    }
}