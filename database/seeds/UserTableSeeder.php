<?php

use App\Pluggable;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // crmpostalmate
        User::create([
            'first_name' => 'CRM PostalMate',
            'last_name' => null,
            'username' => 'crmpostalmate',
            'website' => null,
            'email' => 'crmpostalmate@pcsynergy.com',
            'email_verified_at' => now(),
            'password' => Pluggable::wp_hash_password('Pmate999'),
            'send_notifications' => true,
            'url_image' => null,
            'url_image_thumbnail' => null,
            'address_1' => null,
            'address_2' => null,
            'city' => null,
            'state' => null,
            'zip' => null,
            'country' => null,
            'day_phone' => null,
            'tos' => false,
            'company' => null,
            'enable' => true,
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_ADMMINISTRADOR,
        ]);

        //
        User::create([
            'first_name' => 'Admin Development',
            'last_name' => null,
            'username' => 'admindev',
            'website' => null,
            'email' => 'admindev@aumenta.mx',
            'email_verified_at' => now(),
            'password' => Pluggable::wp_hash_password('Pmate999'),
            'send_notifications' => true,
            'url_image' => null,
            'url_image_thumbnail' => null,
            'address_1' => null,
            'address_2' => null,
            'city' => null,
            'state' => null,
            'zip' => null,
            'country' => null,
            'day_phone' => null,
            'tos' => false,
            'company' => null,
            'enable' => true,
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_ADMMINISTRADOR,
        ]);
    }
}
