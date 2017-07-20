<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Word::class, 69)->create([
            'user_id' => 1,
            'mastered' => 0,
        ]);
    }
}
