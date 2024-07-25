<?php

namespace Database\Seeders;

use App\Models\Boards;
use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boards = Boards::all();
        if ($boards->isEmpty()) {
            Boards::factory(3)->create();
        }

        foreach ($boards as $board) {
            Card::factory(3)->create(['boards_id' => $board->id]);
        }
    }
}
