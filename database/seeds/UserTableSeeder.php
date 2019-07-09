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
            'name' => 'Omar Alejandro Cervantes',
            'email' => 'omar@aumenta.mx',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_ADMMINISTRADOR,
        ]);

        // Regular user
        User::create([
            'name' => 'Josue Don',
            'email' => 'jdon@aumenta.mx',
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(10),
            'verified' => User::USUARIO_VERIFICADO,
            'verification_token' => null,
            'admin' => User::USUARIO_REGULAR,
        ]);
    }
}
