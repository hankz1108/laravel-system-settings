<?php

namespace Hankz\LaravelSystemSettings\Classes;

use Hankz\LaravelSystemSettings\Exceptions\SystemSettingAlreadyExistsException;
use Hankz\LaravelSystemSettings\Models\SystemSetting;

class SystemSettingManager
{
    /**
     * @param string $key
     * @param string $value
     * @param string $group
     * @param string $description
     *
     * @return SystemSetting
     */
    public static function create($key, $value, $group = null, $description = null)
    {
        if (static::has($key, $group)) {
            throw new SystemSettingAlreadyExistsException();
        }

        return SystemSetting::create([
            'key' => $key,
            'value' => $value,
            'group' => $group ?? config('system-settings.default.group'),
            'description' => $description,
        ]);
    }

    /**
     * @param string $key
     * @param string $group
     *
     * @return bool
     */
    public static function has($key, $group = null)
    {
        return static::buildFindQuery($key, $group)->exists();
    }

    /**
     * @param string $key
     * @param string $group
     * @param string $default
     *
     * @return string|null
     */
    public static function get($key, $group = null, $default = null)
    {
        $setting = static::buildFindQuery($key, $group)->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * @param string $group
     * @param string $description
     * @param bool   $createWhenNotExist
     *
     * @return void
     */
    public static function set($key, $value, $group = null, $description = null, $createWhenNotExist = false)
    {
        $setting = static::buildFindQuery($key, $group)->first();

        if ($setting) {
            $setting->value = $value;
            $setting->description = $description;
            $setting->save();
        } elseif ($createWhenNotExist) {
            SystemSetting::create([
                'key' => $key,
                'value' => $value,
                'group' => $group,
                'description' => $description,
            ]);
        }
    }

    /**
     * @param string $group
     *
     * @return array
     */
    public static function getByGroup($group)
    {
        $settings = SystemSetting::where('group', $group)->get();

        return $settings->keyBy('key')->all();
    }

    /**
     * @param array  $settings [key => ['value' => '', 'description' => '']]
     * @param string $group
     *
     * @return void
     */
    public static function setByGroup($settings, $group = null)
    {
        $oldSettings = SystemSetting::where('group', $group)->get();

        foreach ($oldSettings as $oldSetting) {
            if (key_exists($settings, $oldSetting->key)) {
                $newSetting = $settings[$oldSetting->key];

                $oldSetting->value = data_get($newSetting, 'value');
                $oldSetting->description = data_get($newSetting, 'description');
                $oldSetting->save();
            }
        }
    }

    /**
     * @param string $key
     * @param string $group
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function buildFindQuery($key, $group = null)
    {
        if (is_null($group)) {
            $group = config('system-settings.default.group');
        }

        $query = SystemSetting::where('key', $key)
            ->where('group', $group);

        return $query;
    }
}
