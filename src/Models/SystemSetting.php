<?php

namespace Hankz\LaravelSystemSettings\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group',
        'key',
        'value',
        'description',
    ];

    public function __construct()
    {
        $this->table = config('system-settings.table_name');
    }
}
