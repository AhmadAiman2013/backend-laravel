<?php

namespace Database\Seeders;

use App\Models\Boards;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            User::factory(3)->create();
        }
        foreach ($users as $user) {
            Boards::factory(3)->create(['user_id' => $user->id]);
        }
    }
}
