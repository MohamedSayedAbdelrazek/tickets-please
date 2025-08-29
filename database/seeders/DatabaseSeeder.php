<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users=User::factory()->count(10)->create(); // create 10 users 
        Ticket::factory()->count(100)->recycle($users)->create(); // create 100 tickets and assign a random user_id from created users
       
    }
}
