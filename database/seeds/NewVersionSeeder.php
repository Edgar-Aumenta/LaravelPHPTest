<?php

use App\NewVersion;
use Illuminate\Database\Seeder;

class NewVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewVersion::create([
            'version_code' => 1,
            'version_name' => '1.0.0',
            'version_url' => 'http://s3-us-west-1.amazonaws.com/pcsca/Version+11.7.7/11.7.7_InstallSetup.exe',
            'current_version' => false,
            'release_date' => '2019-02-10',
            'estimate_size'=> 250,
            'user_id' => 1
        ]);

        NewVersion::create([
            'version_code' => 2,
            'version_name' => '2.0.0',
            'version_url' => 'http://s3-us-west-1.amazonaws.com/pcsca/Version+11.7.7/11.7.7_InstallSetup.exe',
            'current_version' => true,
            'release_date' => '2019-05-10',
            'estimate_size'=> 256,
            'user_id' => 1
        ]);
    }
}
