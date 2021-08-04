<?php

namespace JalalLinuX\Settings;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'JalalLinuX\Settings\Setting\SettingStorage';
    }
}
