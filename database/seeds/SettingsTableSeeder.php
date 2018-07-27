<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();
        Setting::create([
            'name' => 'Билеты',

            'slug' => 'tickets',
            'body' => '{
            	"title": "Шаг оформления билетов",
            	"value": 1000
            }',

            'active' => true,
        ]);
    }
}
