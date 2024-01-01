<?php

namespace Hankz\LaravelSystemSettings\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'group',
        'key',
        'value',
        'description',
    ];

    public function __construct()
    {
        $this->table = env('system-settings.table_name');
    }
}
