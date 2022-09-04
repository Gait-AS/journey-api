<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'member',
            'last_name' => 'member',
            'role' => 'member',
            'team_id' => 3,
            'email' => 'member@member.com',
            'password' => Hash::make("test")
        ]);

        User::create([
            'first_name' => 'leader',
            'last_name' => 'leader',
            'team_id' => 2,
            'role' => 'leader',
            'email' => 'leader@leader.com',
            'password' => Hash::make("test")
        ]);
        User::create([
            'first_name' => 'master',
            'last_name' => 'master',
            'team_id' => 1,
            'role' => 'master',
            'email' => 'master@master.com',
            'password' => Hash::make("test")
        ]);

        User::factory()
            ->count(30)
            ->create();

        Team::create([
            'name' => 'Backend',
            'team_leader' => 2
        ]);
        Team::create([
            'name' => 'Frontend',
            'team_leader' => 5
        ]);
        Team::create([
            'name' => 'Design',
            'team_leader' => 10
        ]);


        // Team::factory()
        //     ->count(20)
        //     ->create();

        Task::factory()->count(300)->create();
    }
}
