<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VehicleTypeTableSeeder::class);
        $this->call(ParkingTableSeeder::class);
        $this->call(DiscounTableSeeder::class);
    }
}