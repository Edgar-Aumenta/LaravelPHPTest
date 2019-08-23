<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'event_schedules',           
            'lodgings',
            'locations',
            'events',
            'users',
        ]);

        //factory(User::class, 1)->create();
        $this->call(UserTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(LodgingTableSeeder::class);
        $this->call(EventScheduleTableSeeder::class);
        $this->call(WebinarTableSeeder::class);
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // We disable the revision of foreign keys temporary

        foreach($tables as $table){
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // We reactivated the revision of foreign keys
    }
}
