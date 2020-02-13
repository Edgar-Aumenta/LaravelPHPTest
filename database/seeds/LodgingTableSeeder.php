<?php

use App\Lodging;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LodgingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lodging::create([
            'name' => 'SpringHill Suites Orlando Theme Parks/Lake Buena Vista',
            'url' => 'https://www.marriott.com/event-reservations/reservation-link.mi?id=1576240672350&key=GRP&app=resvlink'
        ]);

        Lodging::create([
            'name' => 'Houston Marriott Energy Corridor',
            'url' => 'https://url.emailprotection.link/?b6t_II7rHqeURY3L4E7-KcEv-1AKpnboL9fCKlYHKuJE6gIsmMG5lwI0tzFVjUQ7ysykxAcbCIwUeQylc3URG_smrKI-IRVMV28P19dkGRYYd2LToEGx_2hJn8o84zsEe'
        ]);

        Lodging::create([
            'name' => 'Sheraton Hartford Hotel at Bradley Airport',
            'url' => 'https://www.marriott.com/event-reservations/reservation-link.mi?id=1577973507002&key=GRP&app=resvlink'
        ]);

        Lodging::create([
            'name' => 'Hotel information announced soon',
            'url' => 'https://www.marriott.com/event-reservations/reservation-link.mi?id=1576240672350&key=GRP&app=resvlink'
        ]);
    }
}
