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
            'start_date' => '2020-02-08',
            'end_date' => '2020-02-09',
            'location_id' => 1,
            'event_id' => 1,
            'lodging_id' => 1,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2020Orlando.pdf',
            'mi_title' => 'Scheduled Topics',
            'mi_url' => 'https://pcsynergy.com/pdfs/training/ScheduledTopics2020.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2020-03-21',
            'end_date' => '2020-03-22',
            'location_id' => 2,
            'event_id' => 1,
            'lodging_id' => 2,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2020Houston.pdf',
            'mi_title' => 'Scheduled Topics',
            'mi_url' => 'https://pcsynergy.com/pdfs/training/ScheduledTopics2020.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2020-06-06',
            'end_date' => '2020-06-07',
            'location_id' => 3,
            'event_id' => 1,
            'lodging_id' => 3,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2020Hartford.pdf',
            'mi_title' => 'Scheduled Topics',
            'mi_url' => 'https://pcsynergy.com/pdfs/training/ScheduledTopics2020.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2020-08-29',
            'end_date' => '2020-08-30',
            'location_id' => 4,
            'event_id' => 1,
            'lodging_id' => 4,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2020Seattle.pdf',
            'mi_title' => 'Scheduled Topics',
            'mi_url' => 'https://pcsynergy.com/pdfs/training/ScheduledTopics2020.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);

        // PostalMate Training
        EventSchedule::create([
            'start_date' => '2020-11-07',
            'end_date' => '2020-11-08',
            'location_id' => 5,
            'event_id' => 1,
            'lodging_id' => 4,
            'register_title' => 'Sign Up',
            'register_url' => 'http://www.pcsynergy.com/pdfs/training/2019SanDiego.pdf',
            'mi_title' => 'Scheduled Topics',
            'mi_url' => 'https://pcsynergy.com/pdfs/training/ScheduledTopics2020.pdf',
            'visible' => true,
            'user_id' => 1,
        ]);
    }
}
