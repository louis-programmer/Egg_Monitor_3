<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'preset_setter_survival_rate',
        'preset_hatcher_survival_rate',
        'preset_order_buffer',
        'preset_setter_days',
        'preset_hatcher_days',
        'simulation_minutes_per_day',
    ];
}