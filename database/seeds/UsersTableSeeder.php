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
            'login' => 'admin',

            'email' => 'admin@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Admin',
            'lastname' => 'Admin',

            'type' => 1,

            'avatar' => 'assets/app/media/img/users/300_1.jpg',

            'active' => true,
        ]);
        User::create([
            'login' => 'stock',

            'email' => 'stock@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Stock',
            'lastname' => 'Stock',

            'type' => 4,

            'avatar' => 'assets/app/media/img/users/300_2.jpg',

            'active' => true,
        ]);
        User::create([
            'login' => 'supervisor',

            'email' => 'supervisor@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Супервайзер',
            'lastname' => 'Супервайзер',

            'type' => 3,

            'avatar' => 'assets/app/media/img/users/300_3.jpg',

            'active' => true,
        ]);
        User::create([
            'login' => 'seller',

            'email' => 'seller@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Реализатор',
            'lastname' => 'Реализатор',

            'type' => 2,

            'avatar' => 'assets/app/media/img/users/300_4.jpg',

            'active' => true,
        ]);
        User::create([
            'login' => 'hr',

            'email' => 'hr@gmail.com',
            'password' => bcrypt('test'),

            'name' => 'Отдел кадров',
            'lastname' => 'Отдел кадров',

            'type' => 5,

            'avatar' => 'assets/app/media/img/users/300_5.jpg',

            'active' => true,
        ]);
    }
}
