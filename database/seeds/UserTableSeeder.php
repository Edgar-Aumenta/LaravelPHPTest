<?php

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
        // Admin user
        User::create([
            'first_name' => 'Omar Alejandro',
            'last_name' => 'Cervantes Yepez',
            'username' => 'omaracy',
            'website' => 'www.omaracy.com',
            'email' => 'omar@aumenta.mx',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'send_notifications' => true,
            'url_image' => 'www.image.com',
            'url_image_thumbnail' => 'www.image-thumbnail.com',
            'address_1' => 'Mi direccion',
            'address_2' => null,
            'city' => 'San Luis Potosí',
            'state' => 'San Luis Potosí',
            'zip' => '78000',
            'country' => 'Mexico',
            'day_phone' => 'day phone',
            'tos' => false,
            'company' => 'Mi compañia',
            'enable' => true,
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_ADMMINISTRADOR,
        ]);

        // Regular user
        User::create([
            'first_name' => 'Josue',
            'last_name' => 'Don',
            'username' => 'xozue',
            'website' => 'www.xozue.com',
            'email' => 'jdon@aumenta.mx',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'send_notifications' => true,
            'url_image' => 'www.image.com',
            'url_image_thumbnail' => 'www.image-thumbnail.com',
            'address_1' => 'Mi direccion',
            'address_2' => null,
            'city' => 'San Luis Potosí',
            'state' => 'San Luis Potosí',
            'zip' => '78000',
            'country' => 'Mexico',
            'day_phone' => 'day phone',
            'tos' => false,
            'company' => 'Mi compañia',
            'enable' => true,
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_REGULAR,
        ]);
    }
}
