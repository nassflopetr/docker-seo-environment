<?php

namespace Database\Seeders;

use App\Models\Hall;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HallSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table((new Hall())->getTable())->insert([
            ['id' => 1, 'title' => 'Зал №1', 'seats' => 130, 'created_at' => (new \DateTime()), 'updated_at' => (new \DateTime()),],
            ['id' => 2, 'title' => 'Зал №2', 'seats' => 120, 'created_at' => (new \DateTime()), 'updated_at' => (new \DateTime()),],
            ['id' => 3, 'title' => 'Зал №3', 'seats' => 115, 'created_at' => (new \DateTime()), 'updated_at' => (new \DateTime()),],
        ]);
    }
}
