<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
       
        $users = [
            [
                "name" => "Admin",
                "email" => "M6l2B@example.com",
                "password" => bcrypt("123456"),
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
