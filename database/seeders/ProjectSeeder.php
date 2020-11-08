<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            ['name' => 'Сайт для интернет-магазина'],
            ['name' => 'Сайт ресторана'],
            ['name' => 'Сайт журнала'],
            ['name' => 'Сайт агенства недвижимости']
        ]);
    }
}
