<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table((new Gallery())->getTable())->insert([
            [
                'show_id' => 1,
                'src' => 'images/1.webp',
                'alt' => 'Афіша вистави \'Шепіт ночі\' з виглядом таємничої ночі',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 1,
                'src' => 'images/2.webp',
                'alt' => 'Актори вистави \'Шепіт ночі\', які втілюють таємничі персонажі',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 1,
                'src' => 'images/3.webp',
                'alt' => 'Сцена вистави \'Шепіт ночі\' з декорацією, яка передає атмосферу таємничої ночі',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 2,
                'src' => 'images/4.webp',
                'alt' => 'Афіша вистави \'Танець світла\' з вражаючим світловим дизайном',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 2,
                'src' => 'images/5.webp',
                'alt' => 'Танцівники вистави \'Танець світла\', оточені вражаючими світловими ефектами',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 2,
                'src' => 'images/6.webp',
                'alt' => 'Сцена вистави \'Танець світла\' з величезним світловим витоком, який створює магічну атмосферу',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 3,
                'src' => 'images/7.webp',
                'alt' => 'Афіша вистави \'Симфонія сну\' з магічними образами та кольоровою палітрою',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 3,
                'src' => 'images/8.webp',
                'alt' => 'Танцівники вистави \'Симфонія сну\' у витончених образах, що передають атмосферу сновидінь',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 3,
                'src' => 'images/9.webp',
                'alt' => 'Сцена вистави \'Симфонія сну\' з інтригуючим світловим дизайном та танцювальними елементами',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 3,
                'src' => 'images/10.webp',
                'alt' => 'Артисти вистави \'Симфонія сну\' з музичними інструментами, створюючи гармонійну симфонію',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 4,
                'src' => 'images/11.webp',
                'alt' => 'Афіша вистави \'Легенди прадавнього лісу\' з таємничими образами та відьмами',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 4,
                'src' => 'images/12.webp',
                'alt' => 'Актори вистави \'Легенди прадавнього лісу\' в ролі персонажів легенд та чарівниць',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 4,
                'src' => 'images/13.webp',
                'alt' => 'Сцена вистави \'Легенди прадавнього лісу\' з чудовою візуалізацією лісового царства',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'show_id' => 4,
                'src' => 'images/14.webp',
                'alt' => 'Емоційна гра акторів та талановитий сюжет вистави \'Легенди прадавнього лісу\'',
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
        ]);
    }
}
