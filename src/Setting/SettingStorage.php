<?php

namespace JalalLinuX\Settings\Setting;

use Illuminate\Support\Collection;

interface SettingStorage
{
    /**
     * Get all settings from storage as key value pair.
     *
     * @param bool $fresh ignore cached
     * @return Collection
     */
    public function all(bool $fresh = false): Collection;

    /**
     * Get a setting from storage by key.
     *
     * @param string $key
     * @param null $default
     * @param bool $fresh
     * @return mixed
     */
    public function get(string $key, $default = null, bool $fresh = false);

    /**
     * Check if setting with key exists.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Save a setting in storage.
     *
     * @param $key string|array
     * @param $val string|mixed
     * @return mixed
     */
    public function set(string $key, $val = null);

    /**
     * Remove a setting from storage.
     *
     * @param string $key
     * @return mixed
     */
    public function remove(string $key);

    /**
     * Flush setting cache.
     *
     * @return bool
     */
    public function flushCache(): bool;

    /**
     * Set the group name for settings.
     *
     * @param string $groupName
     * @return $this
     */
    public function group(string $groupName): SettingStorage;
}
