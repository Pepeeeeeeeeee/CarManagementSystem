<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartsSeeder extends Seeder
{
    public function run()
    {
        DB::table('parts')->insert([
            [
                'car_id' => 1,
                'name' => 'TestPart 1',
                'serial_number' => Str::upper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 1,
                'name' => 'TestPart 2',
                'serial_number' => Str::upper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 2,
                'name' => 'TestPart 3',
                'serial_number' => Str::upper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'car_id' => 2,
                'name' => 'TestPart 4',
                'serial_number' => Str::upper(Str::random(8)),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
