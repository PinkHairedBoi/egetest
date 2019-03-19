<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pinky',
            'password' => Hash::make('Pinky'),
            'admin' => true,
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => Hash::make('37DCFVGB'),
            'admin' => false,
        ]);
    }
}