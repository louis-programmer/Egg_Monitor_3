<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        // 28 Solera Setters
        for ($i = 1; $i <= 28; $i++) {
            Machine::create([
                'machine_name' => "Setter {$i}",
                'machine_type' => 'setter',
                'brand' => 'solera',
                'maximum_load' => 45696,
                'minimum_load' => 35002,
                'is_active' => true,
                'status' => 'available',
                'available_on' => null,
            ]);
        }

        // 3 Jamesway Setters
        for ($i = 29; $i <= 31; $i++) {
            Machine::create([
                'machine_name' => "Setter {$i}",
                'machine_type' => 'setter',
                'brand' => 'jamesway',
                'maximum_load' => 31680,
                'minimum_load' => 23768,
                'is_active' => true,
                'status' => 'available',
                'available_on' => null,
            ]);
        }

        // 8 Solera Hatchers
        for ($i = 1; $i <= 8; $i++) {
            Machine::create([
                'machine_name' => "Hatcher {$i}",
                'machine_type' => 'hatcher',
                'brand' => 'solera',
                'maximum_load' => 45696,
                'minimum_load' => 35002,
                'is_active' => true,
                'status' => 'available',
                'available_on' => null,
            ]);
        }

        // 2 Jamesway Hatchers
        for ($i = 9; $i <= 10; $i++) {
            Machine::create([
                'machine_name' => "Hatcher {$i}",
                'machine_type' => 'hatcher',
                'brand' => 'jamesway',
                'maximum_load' => 31680,
                'minimum_load' => 23768,
                'is_active' => true,
                'status' => 'available',
                'available_on' => null,
            ]);
        }
    }
}