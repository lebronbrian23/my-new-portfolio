<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Brian Ssekalegga',
            'username' => 'lebronbrian23',
            'phone_number' => '6476329002',
            'email' => 'ssekalegga@gmail.com',
            'password' => bcrypt('keepkeep'),
        ]);
    }
}
