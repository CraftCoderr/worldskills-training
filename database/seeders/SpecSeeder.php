<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specs')->insert([
            ['name' => 'Backend разработка'],
            ['name' => 'Frontent разработка'],
            ['name' => 'Дизайн'],
            ['name' => 'Тестирование'],
            ['name' => 'Бизнес-аналитика'],
            ['name' => 'Администрирование'],
            ['name' => 'iOS разработчик'],
            ['name' => 'Android разработчик']
        ]);
    }
}
