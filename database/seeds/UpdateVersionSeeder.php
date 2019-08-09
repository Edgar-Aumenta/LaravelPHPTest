<?php

use App\UpdateVersion;
use Illuminate\Database\Seeder;

class UpdateVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UpdateVersion::create([
            'version_code' => 1,
            'version_name' => '1.0.0',
            'current_version' => false,
            'release_date' => '2019-02-10',
            'estimate_size'=> 250,
            'user_id' => 1
        ]);

        UpdateVersion::create([
            'version_code' => 2,
            'version_name' => '2.0.0',
            'current_version' => true,
            'release_date' => '2019-05-10',
            'estimate_size'=> 256,
            'user_id' => 1
        ]);
    }
}
