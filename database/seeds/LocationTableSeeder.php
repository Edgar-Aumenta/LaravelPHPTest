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
        Location::create(['name' => 'Ft Lauderdale, FL']);
        Location::create(['name' => 'Santa Ana, CA']);
        Location::create(['name' => 'Charlotte, NC']);
        Location::create(['name' => 'St Louis, MO']);
        Location::create(['name' => 'Denver, CO']);
        Location::create(['name' => 'Dallas, TX']);
        Location::create(['name' => 'New York, NY']);
        Location::create(['name' => 'Phoenix, AZ']);
        Location::create(['name' => 'Anaheim, CA']);
        Location::create(['name' => 'Las Vegas, NV']);
    }
}
