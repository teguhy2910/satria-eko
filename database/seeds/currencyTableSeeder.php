<?php

use Illuminate\Database\Seeder;

class currencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency')->insert([
            'currency' => 'IDR',
        ]);
        DB::table('currency')->insert([
            'currency' => 'USD',
        ]);
        DB::table('currency')->insert([
            'currency' => 'THB',
        ]);
        DB::table('currency')->insert([
            'currency' => 'JPY',
        ]);
        DB::table('currency')->insert([
            'currency' => 'INR',
        ]);
    }
}
