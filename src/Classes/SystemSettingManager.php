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
     * @return bool
     */
    public static function new($key, $value, $group = null, $description = null)
    {
        if (static::has($key, $group)) {
            throw new SystemSettingAlreadyExistsException();
        }

        return (static::create($key, $value, $group, $description) instanceof SystemSetting);
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
     * @return array
     */
    public static function all()
    {
        return app(SystemSetting::class)->pluck('value', 'key')->toArray();
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
     * @param string $key
     * @param string $value
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
            static::create($key, $value, $group, $description);
        }
    }

    /**
     * @param string $group
     *
     * @return array
     */
    public static function getByGroup($group)
    {
        return app(SystemSetting::class)->select(['key', 'value'])
            ->where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * @param array  $settings           [key => ['value' => '', 'description' => '']]
     * @param string $group
     * @param bool   $createWhenNotExist
     *
     * @return void
     */
    public static function setByGroup($settings, $group = null, $createWhenNotExist = false)
    {
        $oldSettings = app(SystemSetting::class)->where('group', $group)->get();

        foreach ($oldSettings as $oldSetting) {
            if (key_exists($oldSetting->key, $settings)) {
                $newSetting = $settings[$oldSetting->key];

                $oldSetting->value = data_get($newSetting, 'value');
                $oldSetting->description = data_get($newSetting, 'description');
                $oldSetting->save();

                unset($settings[$oldSetting->key]);
            }
        }

        if ($createWhenNotExist) {
            foreach ($settings as $key => $setting) {
                static::create(
                    $key,
                    data_get($setting, 'value'),
                    $group,
                    data_get($setting, 'description')
                );
            }
        }
    }

    /**
     * @param string $key
     * @param string $group
     *
     * @return bool|null
     */
    public static function delete($key, $group = null)
    {
        $setting = static::buildFindQuery($key, $group)->first();

        return $setting ? $setting->delete() : false;
    }

    /**
     * @param string $key
     * @param string $value
     * @param string $group
     * @param string $description
     *
     * @return SystemSetting
     */
    protected static function create($key, $value, $group = null, $description = null)
    {
        $systemSetting = app(SystemSetting::class);

        $systemSetting->fill([
            'key' => $key,
            'value' => $value,
            'group' => $group ?? config('system-settings.default.group'),
            'description' => $description,
        ])->save();

        return $systemSetting;
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

        $query = app(SystemSetting::class)->where('key', $key)
            ->where('group', $group);

        return $query;
    }
}
