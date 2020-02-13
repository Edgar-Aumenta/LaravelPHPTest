<?php

use App\Webinar;
use Illuminate\Database\Seeder;

class WebinarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Webinar::create([
            'start_date' => '2018-04-25',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => "Customers and Ship To's",
            'recorded_url' => 'https://www.youtube.com/embed/gXrmLIpnL5U?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-05-16',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'FedEx International in PostalMate®',
            'recorded_url' => 'https://www.youtube.com/embed/_C2_O69dAfU?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-05-23',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Evaluating your Store',
            'recorded_url' => 'https://www.youtube.com/embed/gXrmLIpnL5U?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-06-20',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '	Receipts - Upgrade Your Look in CashMate',
            'recorded_url' => 'https://www.youtube.com/embed/0jeIw1tzx6c?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-06-27',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'It cost WHAT to ship that???',
            'recorded_url' => 'https://www.youtube.com/embed/glcTEVkpRRI?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-07-11',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New UPS Rate Structure Change',
            'recorded_url' => 'https://www.youtube.com/embed/azVQPl7sxzs?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-07-18',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => "Let's Check our UPS Rates",
            'recorded_url' => 'https://www.youtube.com/embed/ZjcJQ8YPPw4?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-07-25',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Customizing your Rate Comparison Screen',
            'recorded_url' => 'https://www.youtube.com/embed/JkRIOU0xYUA?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-08-22',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Evaluate Your UPS Rate Settings',
            'recorded_url' => 'https://www.youtube.com/embed/g_cpReeH9Gk?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-09-19',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Print Professional Estimates',
            'recorded_url' => 'https://www.youtube.com/embed/6yadqYr531w?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-10-24',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'FedEx Rate Structure Change',
            'recorded_url' => 'https://www.youtube.com/embed/yuXDQXBjRMg?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-10-31',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '	Showing FedEx Changes in PostalMate',
            'recorded_url' => 'https://www.youtube.com/embed/ooLen95V6aM?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2018-11-28',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Get Ready for the Holidays Rate Review',
            'recorded_url' => 'https://www.youtube.com/embed/w9CLAeLxPFw?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-01-16',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '2019 UPS, FedEx, and DHL Rate Change',
            'recorded_url' => 'https://www.youtube.com/embed/SnH_1JA6htU?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-01-30',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '2019 USPS Changes that affect your store',
            'recorded_url' => 'https://www.youtube.com/embed/HBR5hu-uTg0?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-02-27',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Certified Mail in PostalMate with Endicia',
            'recorded_url' => 'https://www.youtube.com/embed/t6lQ5U9eLEA?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-03-06',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New UPS and FedEx changes you need to know and Drop-offs',
            'recorded_url' => 'https://www.youtube.com/embed/K9YGf3W8RcY?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-03-13',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New Owners Quick Start',
            'recorded_url' => 'https://www.youtube.com/embed/kyIPmWoBXBs?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => false,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-04-3',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '6 Tools for Making Money With Cubic Rates',
            'recorded_url' => 'https://www.youtube.com/embed/vGeGhA-Hwo4?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-04-17',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Retail Supplies - Am I charging enough?',
            'recorded_url' => 'https://www.youtube.com/embed/dUXP2YCVRPY?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-04-24',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Departments and Products - 5 ways to make your POS work better',
            'recorded_url' => 'https://www.youtube.com/embed/HVAw38Z2xto?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-05-15',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => "10 International No-no's",
            'recorded_url' => 'https://www.youtube.com/embed/3b5ESK2Sj6c?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-06-12',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New DHL Changes in PostalMate',
            'recorded_url' => 'https://www.youtube.com/embed/MhK21J6LM3k?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-06-26',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'USPS Secret Rate Increase',
            'recorded_url' => 'https://www.youtube.com/embed/3z_OrWX_N6M?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-07-12',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Endicia DYMO/NetStamps News',
            'recorded_url' => 'https://www.youtube.com/embed/S4U10u_mAjY?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-07-17',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'DHL Rate Setting-Complete with DHL online pricing!',
            'recorded_url' => 'https://www.youtube.com/embed/3z_OrWX_N6M?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-07-31',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => '10 USPS Rules You May Not Know',
            'recorded_url' => 'https://www.youtube.com/embed/MyHu9r8VOB8?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-10-09',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New Owners Quick Start',
            'recorded_url' => 'https://www.youtube.com/embed/LpapGqyJP0E?wmode=transparent&hd=0&autoplay=1&controls=1&fs=1&autohide=2&theme=dark&rel=0&showinfo=1&iv_load_policy=3',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2019-11-13',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Holiday Rates with Tips and Tricks',
            'recorded_url' => 'https://register.gotowebinar.com/recording/6543608615637665030',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2020-01-29',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'Post Office/Endicia Rate Update',
            'register_url' => '',
            'visible' => true,
            'user_id' => 1
        ]);

        Webinar::create([
            'start_date' => '2020-02-12',
            'start_time' => '10:00:00',
            'time_zone_desc' => 'Pacific',
            'name' => 'New Owners Quick Start',
            'register_url' => 'https://attendee.gotowebinar.com/rt/8622929132972006413',
            'visible' => true,
            'user_id' => 1
        ]);
    }
}
