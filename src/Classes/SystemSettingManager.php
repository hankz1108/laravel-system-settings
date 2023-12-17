<?php

namespace Hankz\LaravelSystemSettings\Classes;

use Hankz\LaravelSystemSettings\Models\SystemSetting;

class SystemSettingManager
{
    /**
     * @var SystemSetting
     */
    protected $setting;

    public function __construct(SystemSetting $setting)
    {
        $this->setting = $setting;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public static function has($key, $group = 'default')
    {
        return SystemSetting::where('key', $key)
            ->where('group', $group)
            ->exists();
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return string|null
     */
    public static function get($key, $default = null, $group = 'default')
    {
        $setting = SystemSetting::where('key', $key)
            ->where('group', $group)
            ->first();

        return $setting ? $setting->value : $default;
    }

    /**
     * @param string $group
     *
     * @return void
     */
    public static function getGroup($group)
    {
        $settings = SystemSetting::where('group', $group)->get();

        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }

        return $result;
    }

    /**
     * @param $key
     * @param $value
     * @param string $group
     * @param null $description
     * @param bool $createWhenNotExist
     *
     * @return void
     */
    public static function set($key, $value, $group = 'default', $description = null, $createWhenNotExist = false)
    {
        $setting = SystemSetting::where('key', $key)
            ->where('group', $group)
            ->first();

        if ($setting) {
            $setting->value = $value;
            $setting->description = $description;
            $setting->save();
        } else if ($createWhenNotExist) {
            SystemSetting::create([
                'key' => $key,
                'value' => $value,
                'group' => $group,
                'description' => $description,
            ]);
        }
    }

    // TODO: setGroup、create
}