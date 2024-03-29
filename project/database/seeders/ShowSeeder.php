<?php

namespace Database\Seeders;

use App\Models\Show;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table((new Show())->getTable())->insert([
            [
                'id' => 1,
                'hall_id' => 1,
                'metadata' => \json_encode([
                    'h1' => 'Шепіт ночі: Таємнича вистава в Театральному Порталі',
                    'title' => 'Купити квитки на виставу \'Шепіт ночі\' - Інформація та ціни | Театральний Портал',
                    'keywords' => 'вистава, Шепіт ночі, таємнича вистава, ніч, театр, квитки',
                    'og:title' => 'ККупити квитки на виставу \'Шепіт ночі\' - Інформація та ціни | Театральний Портал',
                    'description' => 'Дізнайтеся більше про таємничу виставу \'Шепіт ночі\'. Розкривайте найглибші таємниці у світі ночі. Купуйте квитки за доступною ціною.',
                    'og:description' => 'Дізнайтеся більше про таємничу виставу \'Шепіт ночі\'. Розкривайте найглибші таємниці у світі ночі. Купуйте квитки за доступною ціною.',
                ]),
                'title' => 'Шепіт ночі',
                'description' => 'Ця таємнича вистава розповідає історію про те, як ніч може приховувати найглибші таємниці. Зануртеся у світ, де кожен шепіт ночі несе з собою загадки та сюрпризи.',
                'start_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(19, 30),
                'end_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(21, 15),
                'price' => 130,
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'id' => 2,
                'hall_id' => 2,
                'metadata' => \json_encode([
                    'h1' => 'Танець світла: Захоплююча вистава в Театральному Порталі',
                    'title' => 'Купити квитки на виставу \'Танець світла\' - Інформація та ціни | Театральний Портал',
                    'keywords' => 'вистава, Танець світла, світло, танець, театр, квитки',
                    'og:title' => 'Купити квитки на виставу \'Танець світла\' - Інформація та ціни | Театральний Портал',
                    'description' => 'Дізнайтеся більше про захоплюючу виставу \'Танець світла\'. Розкривайте таємниці світла та танцю у неймовірній атмосфері. Купуйте квитки за доступною ціною.',
                    'og:description' => 'Дізнайтеся більше про захоплюючу виставу \'Танець світла\'. Розкривайте таємниці світла та танцю у неймовірній атмосфері. Купуйте квитки за доступною ціною.',
                ]),
                'title' => 'Танець світла',
                'description' => 'В цій феєричній виставі світло виступає головним героєм. Дивовижні світлові ефекти та танці створюють магічну атмосферу, яка залишить вас зачарованими.',
                'start_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(19, 45),
                'end_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(21, 35),
                'price' => 150,
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'id' => 3,
                'hall_id' => 3,
                'metadata' => \json_encode([
                    'h1' => 'Симфонія сну: Чарівна вистава в Театральному Порталі',
                    'title' => 'Купити квитки на виставу \'Симфонія сну\' - Інформація та ціни | Театральний Портал',
                    'keywords' => 'вистава, Симфонія сну, сни, музика, танці, театр, квитки',
                    'og:title' => 'Купити квитки на виставу \'Симфонія сну\' - Інформація та ціни | Театральний Портал',
                    'description' => 'Дізнайтеся більше про чарівну виставу \'Симфонія сну\'. Поглибіться у світ снів, де музика, кольори та танці створюють неймовірну симфонію. Купуйте квитки за доступною ціною.',
                    'og:description' => 'Дізнайтеся більше про чарівну виставу \'Симфонія сну\'. Поглибіться у світ снів, де музика, кольори та танці створюють неймовірну симфонію. Купуйте квитки за доступною ціною.',
                ]),
                'title' => 'Симфонія сну',
                'description' => 'Відправтеся у подорож у світ снів, де музика, кольори та танці об\'єднуються в гармонійну симфонію. Ця вистава перенесе вас у реальність сновидінь.',
                'start_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(20, 00),
                'end_at' => (new \DateTime())->add((new \DateInterval('P58D')))->setTime(21, 50),
                'price' => 165,
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
            [
                'id' => 4,
                'hall_id' => 1,
                'metadata' => \json_encode([
                    'h1' => 'Легенди прадавнього лісу: Захоплююча вистава в Театральному Порталі',
                    'title' => 'Купити квитки на виставу \'Легенди прадавнього лісу\' - Інформація та ціни | Театральний Портал',
                    'keywords' => 'вистава, Легенди прадавнього лісу, легенди, відьми, театр, квитки',
                    'og:title' => 'Купити квитки на виставу \'Легенди прадавнього лісу\' - Інформація та ціни | Театральний Портал',
                    'description' => 'Дізнайтеся більше про захоплюючу виставу \'Легенди прадавнього лісу\'. Відправтеся у магічний світ легенд та відьом. Купуйте квитки за доступною ціною.',
                    'og:description' => 'Дізнайтеся більше про захоплюючу виставу \'Легенди прадавнього лісу\'. Відправтеся у магічний світ легенд та відьом. Купуйте квитки за доступною ціною.',
                ]),
                'title' => 'Легенди прадавнього лісу',
                'description' => 'Дізнайтеся про захоплюючу виставу \'Легенди прадавнього лісу\', яка вводить глядачів у магічний світ легенд та відьом. Споглядайте, як стародавні оповідання оживають на сцені, де вас очікує пригоди, таємниці та зачарована краса лісового царства. Вражайтеся дотепним сюжетом, талановитою грою акторів та чарівною атмосферою цієї вистави. Купуйте квитки зараз та вирушайте у неповторний світ \'Легенд прадавнього лісу\'.',
                'start_at' => (new \DateTime())->add((new \DateInterval('P59D')))->setTime(19, 45),
                'end_at' => (new \DateTime())->add((new \DateInterval('P59D')))->setTime(21, 40),
                'price' => 160,
                'created_at' => (new \DateTime()),
                'updated_at' => (new \DateTime()),
            ],
        ]);
    }
}
