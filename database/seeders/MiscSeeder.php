<?php

namespace Database\Seeders;

use App\Models\Misc;
use Illuminate\Database\Seeder;

class MiscSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Misc::factory()->count(6)->create();
    }
}
