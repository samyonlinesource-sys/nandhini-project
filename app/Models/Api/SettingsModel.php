<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $fillable = [
        'version',
        'app_mode',
        'maintenance_mode',
    ];
}
