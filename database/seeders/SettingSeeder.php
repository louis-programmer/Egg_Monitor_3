<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Setting::create([
            'preset_setter_survival_rate' => 77,
            'preset_hatcher_survival_rate' => 85,
            'preset_order_buffer' => 65,
            'preset_setter_days' => 18,
            'preset_hatcher_days' => 3,
            'simulation_minutes_per_day' => 1,
        ]);
    }
}
