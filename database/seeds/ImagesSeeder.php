<?php

use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('images')->insert([
            'question_id' => 1,
            'src' => '/images/img1.jpg',
        ]);
        DB::table('images')->insert([
            'question_id' => 1,
            'src' => '/images/img2.jpg',
        ]);
    }
}
