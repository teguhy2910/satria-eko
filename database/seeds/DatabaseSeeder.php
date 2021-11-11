<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(originTableSeeder::class);
        $this->call(suplierTableSeeder::class);
        $this->call(currencyTableSeeder::class);
        $this->call(UserSeedTable::class);
        $this->call(ForwaderSeedTable::class);
    }
}
