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
            'email' => 'exim@aiia.co.id',
            'password' => bcrypt('admin'),
            ]);
            DB::table('users')->insert([
            'name' => 'kasir',
            'email' => 'kasir@aiia.co.id',
            'password' => bcrypt('admin'),
            ]);
            DB::table('users')->insert([
            'name' => 'finance',
            'email' => 'eko@aiia.co.id',
            'password' => bcrypt('admin'),
            ]);
            DB::table('users')->insert([
            'name' => 'ppic',
            'email' => 'ppic@aiia.co.id',
            'password' => bcrypt('admin'),
            ]);
    }
}
