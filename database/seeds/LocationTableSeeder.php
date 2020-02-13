<?php

use App\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Location::create(['name' => 'Orlando, FL']);
        Location::create(['name' => 'Houston, TX']);
        Location::create(['name' => 'Hartford, CT']);
        Location::create(['name' => 'Seattle, WA']);
        Location::create(['name' => 'San Diego, CA']);
    }
}
