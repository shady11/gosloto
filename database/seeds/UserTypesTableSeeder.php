<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\UserType as UserType;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        
        UserType::truncate();
        UserType::create([
            'name' => 'Администратор',
            'slug' => 'admin',
        ]);
        UserType::create([
            'name' => 'Реализатор',
            'slug' => 'seller',
        ]);
        UserType::create([
            'name' => 'Супервайзер',
            'slug' => 'supervisor',
        ]);
        UserType::create([
            'name' => 'Склад',
            'slug' => 'stock',
        ]);
        UserType::create([
            'name' => 'Отдел кадров',
            'slug' => 'hr',
        ]);
        UserType::create([
            'name' => 'Касса',
            'slug' => 'cash',
        ]);
    }
}
