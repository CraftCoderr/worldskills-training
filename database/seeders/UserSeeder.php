<?php

namespace Database\Seeders;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Hasher $hasher)
    {
        DB::table('users')->insert([
            [
                'name' => 'Менеджер',
                'surname' => 'Менеджер',
                'spec_id' => 1,
                'project_id' => 1,
                'email' => 'mp@mail.com',
                'password'=> $hasher->make('mp2020'),
                'photo' => '/assets/avatar.jpeg'
            ],
            [
                'name' => 'Программист',
                'surname' => 'Программист',
                'spec_id' => 1,
                'project_id' => 1,
                'email' => 'prog1@mail.com',
                'password'=> $hasher->make('prog2020'),
                'photo' => '/assets/avatar.jpeg'
            ]
        ]);
    }
}
