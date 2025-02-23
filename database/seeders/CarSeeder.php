<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarSeeder extends Seeder
{
    public function run()
    {
        DB::table('cars')->insert([
            [
                'name' => 'TestCar 1',
                'registration_number' => Str::upper(Str::random(8)),
                'is_registered' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TestCar 2',
                'registration_number' => 'null',
                'is_registered' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
