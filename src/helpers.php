<?php

if (! function_exists('settings')) {
    /**
     * Get app setting stored in db.
     *
     * @param string|null $key
     * @param string|null $default
     * @return JalalLinuX\Settings\Setting\SettingStorage|mixed
     */
    function settings(string $key = null, string $default = null)
    {
        $setting = app()->make('JalalLinuX\Settings\Setting\SettingStorage');

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key)) {
            return $setting->set($key);
        }

        return $setting->get($key, value($default));
    }
}

if (!function_exists('isJsonString')) {
    function isJsonString(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
