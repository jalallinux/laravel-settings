<?php

namespace JalalLinuX\Settings\Setting;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingEloquentStorage implements SettingStorage
{
    /**
     * Group name.
     *
     * @var string
     */
    protected string $settingsGroupName = 'default';

    /**
     * Cache key.
     *
     * @var string
     */
    protected string $settingsCacheKey = '_app_settings';

    /**
     * {@inheritdoc}
     */
    public function all(bool $fresh = false): Collection
    {
        if ($fresh) {
            return $this->modelQuery()->pluck('val', 'name');
        }

        return Cache::rememberForever($this->getSettingsCacheKey(), function () {
            return $this->modelQuery()->pluck('val', 'name');
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key, $default = null, $fresh = false)
    {
        return $this->all($fresh)->get($key, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, $val = null)
    {
        // if its an array, batch save settings
        if (is_array($key)) {
            foreach ($key as $name => $value) {
                $this->set($name, $value);
            }

            return true;
        }

        $setting = $this->getSettingModel()->firstOrNew([
            'name' => $key,
            'group' => $this->settingsGroupName,
        ]);

        $setting->val = $val;
        $setting->group = $this->settingsGroupName;
        $setting->save();

        $this->flushCache();

        return $val;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $key): bool
    {
        return $this->all()->has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $key)
    {
        $deleted = $this->getSettingModel()->where('name', $key)->delete();

        $this->flushCache();

        return $deleted;
    }

    /**
     * {@inheritdoc}
     */
    public function flushCache(): bool
    {
        return Cache::forget($this->getSettingsCacheKey());
    }

    /**
     * Get settings cache key.
     *
     * @return string
     */
    protected function getSettingsCacheKey(): string
    {
        return $this->settingsCacheKey.'.'.$this->settingsGroupName;
    }

    /**
     * Get settings eloquent model.
     *
     * @return Builder
     */
    protected function getSettingModel(): Builder
    {
        return app('\JalalLinuX\Settings\Setting\Setting');
    }

    /**
     * Get the model query builder.
     *
     * @return Builder
     */
    protected function modelQuery(): Builder
    {
        return $this->getSettingModel()->group($this->settingsGroupName);
    }

    /**
     * Set the group name for settings.
     *
     * @param string $groupName
     * @return $this
     */
    public function group(string $groupName): SettingStorage
    {
        $this->settingsGroupName = $groupName;

        return $this;
    }
}
