<?php

namespace JalalLinuX\Settings;

trait HasSetting
{
    public static function getSetting(string $key)
    {
        return settings()->group(static::class)->get($key);
    }

    public static function setSetting($key, $value = null)
    {
        return settings()->group(static::class)->set($key, $value);
    }
}
