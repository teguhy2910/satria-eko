<?php

use Illuminate\Database\Seeder;

class originTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('origin')->insert([
            'origin' => 'Jepang',
        ]);
        DB::table('origin')->insert([
            'origin' => 'Thailand',
        ]);
        DB::table('origin')->insert([
            'origin' => 'China',
        ]);
        DB::table('origin')->insert([
            'origin' => 'Taiwan',
        ]);
        DB::table('origin')->insert([
            'origin' => 'India',
        ]);
        DB::table('origin')->insert([
            'origin' => 'Amerika',
        ]);
    }
}
