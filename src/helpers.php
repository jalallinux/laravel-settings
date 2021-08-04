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

if (!function_exists('_settings')) {
    /**
     * @param string $group
     * @param string $key
     * @param bool $fresh
     * @return mixed
     */
    function _settings(string $group, string $key = '*', bool $fresh = false)
    {
        /* $fresh ignore cached */
        return $key == '*'
            ? settings()->group($group)->all($fresh)
            : settings()->group($group)->get($key, null, $fresh);
    }
}