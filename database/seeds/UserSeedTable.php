<?php

use Illuminate\Database\Seeder;
class UserSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@aiia.co.id',
            'password' => bcrypt('admin'),
            ]);
            DB::table('users')->insert([
            'name' => 'finance',
            'email' => 'finance@aiia.co.id',
            'password' => bcrypt('finance'),
            ]);
            DB::table('users')->insert([
            'name' => 'ppic',
            'email' => 'ppic@aiia.co.id',
            'password' => bcrypt('ppic'),
            ]);
            DB::table('users')->insert([
            'name' => 'pc',
            'email' => 'pc@aiia.co.id',
            'password' => bcrypt('pc'),
            ]);
    }
}
