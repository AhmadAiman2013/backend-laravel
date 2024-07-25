<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cards = Card::all();
        if ($cards->isEmpty()) {
            Card::factory(3)->create();
        }

        foreach ($cards as $card) {
            Task::factory(3)->create(['card_id' => $card->id]);
        }
    }
}
