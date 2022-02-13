<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scalars = [1000 => '1kg', 500 => '500gr', 300 => '300gr', 250 => '250gr', 200 => '200gr', 150 => '150gr', 100 => '100gr'];
        foreach($scalars as $key => $value) {
            DB::table('scales')->insert([
                'scalar' => $value,
                'pergram' => $key
            ]);
        }
    }
}
