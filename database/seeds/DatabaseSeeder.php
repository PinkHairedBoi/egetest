<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TestsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(ImagesSeeder::class);
        $this->call(AnswersSeeder::class);
    }
}
