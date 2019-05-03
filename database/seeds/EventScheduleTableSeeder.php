<?php

use App\EventSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2019-02-09',
            'end_date' => '2019-02-10',
            'location_id' => 1,
            'event_id' => 1,
            'lodging_id' => 1,
            'register_title' => null,
            'register_url' => null,
            'mi_title' => 'Class Descriptions',
            'mi_url' => 'http://www.pcsynergy.com/pdfs/training/2019ClassDescriptions.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);
        
        // PostalMate Class N' Clinic
        EventSchedule::create([
            'start_date' => '2019-03-22',
            'end_date' => null,
            'location_id' => 2,
            'event_id' => 3,
            'lodging_id' => 2,
            'register_title' => null,
            'register_url' => null,
            'mi_title' => null,
            'mi_url' => null,
            'visible' => true,
            'user_id' => 1,
        ]);

        // RS Workshop
        EventSchedule::create([
            'start_date' => '2019-03-23',
            'end_date' => '2019-03-24',
            'location_id' => 2,
            'event_id' => 4,
            'lodging_id' => 2,            
            'register_title' => null,
            'register_url' => null,
            'mi_title' => null,
            'mi_url' => null,
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2019-04-06',
            'end_date' => '2019-03-07',
            'location_id' => 3,
            'event_id' => 1,
            'lodging_id' => 3,
            'register_title' => null,
            'register_url' => null,
            'mi_title' => null,
            'mi_url' => null,
            'visible' => true,
            'user_id' => 1,
        ]);

        // AMBC Basic Training
        EventSchedule::create([
            'start_date' => '2019-04-26',
            'end_date' => '2019-04-28',
            'location_id' => 4,
            'event_id' => 5,
            'lodging_id' => 4,
            'register_title' => 'Sign Up',
            'register_url' => 'https://ambc.org/event-registration/',
            'mi_title' => 'Weekend Agenda',
            'mi_url' => 'https://ambc.org/ambc-certified-training-weekend-april-26-2019/',
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2019-05-04',
            'end_date' => '2019-05-05',
            'location_id' => 5,
            'event_id' => 1,
            'lodging_id' => 5,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2019Denver.pdf',
            'mi_title' => 'Class Descriptions',
            'mi_url' => 'http://www.pcsynergy.com/pdfs/training/2019ClassDescriptions.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // RSA Expo
        EventSchedule::create([
            'start_date' => '2019-08-21',
            'end_date' => '2019-08-25',
            'location_id' => 6,
            'event_id' => 6,
            'lodging_id' => 6,
            'register_title' => 'Info',
            'register_url' => 'https://www.rscentral.org/Events/RS-Expo#183381-overview',
            'mi_title' => null,
            'mi_url' => null,
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Regional
        EventSchedule::create([
            'start_date' => '2019-09-21',
            'end_date' => '2019-09-22',
            'location_id' => 7,
            'event_id' => 2,
            'lodging_id' => 7,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2019NewYork.pdf',
            'mi_title' => 'Class Descriptions',
            'mi_url' => 'http://www.pcsynergy.com/pdfs/training/2019ClassDescriptions.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // Print and Ship Symposium
        EventSchedule::create([
            'start_date' => '2019-10-18',
            'end_date' => null,
            'location_id' => 10,
            'event_id' => 7,
            'lodging_id' => 8,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2018Baltimore.pdf',
            'mi_title' => 'Print & Ship Symposium',
            'mi_url' => 'https://fzsupplies.com/collections/zoom-u/products/zoom-u',
            'visible' => false,
            'user_id' => 1,
        ]);

        // AMBC Workshop
        EventSchedule::create([
            'start_date' => '2019-11-01',
            'end_date' => '2019-11-03',
            'location_id' => 8,
            'event_id' => 8,
            'lodging_id' => 9,
            'register_title' => 'Info',
            'register_url' => 'https://ambc.org/ambcs-the-event-2019-an-annual-workshop-to-network-train-and-grow-together/',
            'mi_title' => null,
            'mi_url' => null,
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Regional
        EventSchedule::create([
            'start_date' => '2019-11-16',
            'end_date' => '2019-11-17',
            'location_id' => 9,
            'event_id' => 2,
            'lodging_id' => 10,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2019Anaheim.pdf',
            'mi_title' => 'Class Descriptions',
            'mi_url' => 'http://www.pcsynergy.com/pdfs/training/2019ClassDescriptions.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);
    }
}
