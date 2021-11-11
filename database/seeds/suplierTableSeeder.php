<?php

use Illuminate\Database\Seeder;

class suplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('suplier')->insert([
            'suplier' => 'Aisin Seiki',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Aisin Asia',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Yano Electronic',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Thai Krungthai',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Nippo Mechatronic',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Toyo Corporation',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Toyo Machinery',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Uchiyama',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Okaya Thailand',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Minebea',
        ]);
        DB::table('suplier')->insert([
            'suplier' => 'Okaya & Co., LTD',
        ]);
    }
}
