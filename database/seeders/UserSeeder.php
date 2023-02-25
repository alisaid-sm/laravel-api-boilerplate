<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Firebase\JWT\JWT;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $key = env("JWT_SECRET_LOGIN");

        $payload = [
            'iat' => time(),
        ];

        \App\Models\User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'remember_token' => JWT::encode($payload, $key, 'HS256'),
        ]);
    }
}
