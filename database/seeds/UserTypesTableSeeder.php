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
        ]);
    }
}
