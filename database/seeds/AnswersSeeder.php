<?php

use Illuminate\Database\Seeder;
use App\User;

class AnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $u) {
            DB::table('answers')->insert([
                'question_id' => 1,
                'user_id' => $u->id,
                'is_right' => true,
                'attempt' => 1
            ]);
        }
    }
}