<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DiscounTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->insert([
            'id' => 1,
            'discount' => 10,
            'minutes' => 1,
        ]);
    }
}