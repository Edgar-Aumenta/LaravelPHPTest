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
            'name' => 'Courtyard Fort Lauderdale', 
            'url' => 'https://www.marriott.com/hotels/travel/fllcp-courtyard-fort-lauderdale-north-cypress-creek/?app=resvlink'
        ]);

        Lodging::create([
            'name' => 'Embassy Suites by Hilton Santa Ana Orange County', 
            'url' => 'https://embassysuites.hilton.com/en/es/groups/personalized/S/STAESES-XRS-20190321/index.jhtml'
        ]);

        Lodging::create([
            'name' => 'Courtyard Charlotte Airport/Billy Graham Parkway', 
            'url' => 'https://www.marriott.com/meeting-event-hotels/group-corporate-travel/groupCorp.mi?resLinkData=PC%20Synergy%5ECLTSW%60PCSPCSK%6099%60USD%60false%602%604/5/19%604/8/19%603/22/19&app=resvlink&stop_mobi=yes'
        ]);        

        Lodging::create([
            'name' => 'Hilton Garden In St Louis Airport',
            'url' => 'https://secure3.hilton.com/en_US/gi/reservation/book.htm?execution=e1s1'
        ]);

        Lodging::create([
            'name' => 'Courtyard Denver Airport',
            'url' => 'https://www.marriott.com/meeting-event-hotels/group-corporate-travel/groupCorp.mi?resLinkData=Postal%20PostalMate/RS%20Associates%5Edenap%60PPMPPMA%60120.00%60USD%60false%602%605/3/19%605/6/19%604/19/19&app=resvlink&stop_mobi=yes'
        ]);

        Lodging::create([
            'name' => 'Hyatt Regency Dallas',
            'url' => 'https://www.rscentral.org/Events/RS-Expo#183388-hotel--attractions'
        ]);

        Lodging::create([
            'name' => 'New York Laguardia Airport Marriott',
            'url' => 'https://www.marriott.com/meeting-event-hotels/group-corporate-travel/groupCorp.mi?resLinkData=PC%20Synergy%20Attendees%5Elgaap%60po1po1a%60209.00%60USD%60false%602%609/21/19%609/24/19%609/6/19&app=resvlink&stop_mobi=yes'
        ]);

        Lodging::create([
            'name' => 'Baltimore Marriott Inner Harbor at Camden Yards',
            'url' => 'https://aws.passkey.com/event/49566521/owner/289/home'
        ]);

        Lodging::create([
            'name' => 'Hilton Phoenix Airport',
            'url' => 'https://www.hilton.com/en/hi/groups/personalized/P/PHXAHHF-AMBC-20191030/index.jhtml'
        ]);

        Lodging::create([
            'name' => 'Anaheim Marriott Suites',
            'url' => 'https://www.marriott.com/meeting-event-hotels/group-corporate-travel/groupCorp.mi?resLinkData=Postal%20Mate%20/%20RS%20Associates%20Training%5Esnaas%60PSMPSMA%60130%60USD%60false%604%6011/15/19%6011/18/19%6010/25/19&app=resvlink&stop_mobi=yes'
        ]);
    }
}
