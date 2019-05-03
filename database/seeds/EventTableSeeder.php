<?php

use App\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create(['name' => 'PostalMate Training']);
        Event::create(['name' => 'PostalMate Regional']);
        Event::create(['name' => "PostalMate Class N' Clinic"]);
        Event::create(['name' => 'RS Workshop']);
        Event::create(['name' => 'AMBC Basic Training']);        
        Event::create(['name' => 'RSA Expo']);
        Event::create(['name' => 'Print and Ship Symposium']);
        Event::create(['name' => 'AMBC Workshop']);
    }
}
