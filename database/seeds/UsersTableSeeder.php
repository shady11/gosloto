<?php

use Illuminate\Database\Seeder;
use App\Models\User as User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'login' => 'shady',

            'email' => 'kendirbaev.aibek@gmail.com',
            'password' => bcrypt('slimshady11'),

            'name' => 'Айбек',
            'lastname' => 'Кендирбаев',

            'type' => 1,

            'avatar' => 'assets/app/media/img/users/300_12.jpg',

            'active' => true,
        ]);
        User::create([
            'login' => 'sh4dy',

            'email' => 'kendirbaev11@gmail.com',
            'password' => bcrypt('1qaz'),

            'name' => 'Аман',
            'lastname' => 'Эсен',

            'type' => 1,

            'avatar' => 'assets/app/media/img/users/300_3.jpg',

            'active' => true,
        ]);
    }
}
