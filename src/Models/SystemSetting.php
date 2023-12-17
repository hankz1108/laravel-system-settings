<?php

namespace Hankz\LaravelSystemSettings\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    public function __construct()
    {
        $this->table = env('system-settings.table_name');
    }

    protected $fillable = [
        'group',
        'key',
        'value',
        'description',
    ];
}
