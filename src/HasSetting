<?php

namespace JalalLinuX\Settings;

trait HasSetting
{
    public static function getSetting(string $key)
    {
        return settings()->group(static::class)->get($key);
    }

    public static function setSetting(string $key, $value)
    {
        return settings()->group(static::class)->set($key, $value);
    }
}
