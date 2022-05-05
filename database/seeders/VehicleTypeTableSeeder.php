<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class VehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicle_types')->insert([
            'id' => 1,
            'type' => 'Automovil',
            'fee' => 30
        ]);

        DB::table('vehicle_types')->insert([
            'id' => 2,
            'type' => 'Bicicleta',
            'fee' => 10
        ]);

        DB::table('vehicle_types')->insert([
            'id' => 3,
            'type' => 'Motocicleta',
            'fee' => 20
        ]);
    }
}