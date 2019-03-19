<?php

use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tests')->insert([
            'name' => 'Vopros 1',
            'order' => 1,
        ]);
        DB::table('tests')->insert([
            'name' => 'Vopros 2',
            'order' => 2,
        ]);
        DB::table('tests')->insert([
            'name' => 'Vopros 3',
            'order' => 3,
        ]);
    }
}
