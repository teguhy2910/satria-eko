<?php

use Illuminate\Database\Seeder;

class ForwaderSeedTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('forwader')->insert([
            'namappjk' => 'PT. PUNINAR JAYA',
            'npwpppjk' => '1.300.326.4-046.000',
            'namapimpinanppjk' => 'RIYANTO',
            'alamatppjk' => 'Jl. RAYA CAKUNG CILINCING KM 1.5 JAKARTA 13910',
            'telppjk' => '( 021 ) 46827777 / ( 021 ) 46835887',
        ]);
        DB::table('forwader')->insert([
            'namappjk' => 'PT. UNIAIR INDOTAMA CARGO',
            'npwpppjk' => '01.344.485.6-073.000',
            'namapimpinanppjk' => 'SALMON JOSEFIANO',
            'alamatppjk' => 'UNIAIR Building, Jl Danau Sunter Barat A3/40 Sunter Agung Podomoro Jakarta Utara 14350',
            'telppjk' => '021-65838080 / 021-65835599',
        ]);
        DB::table('forwader')->insert([
            'namappjk' => 'PT FM GLOBAL LOGISTICS',
            'npwpppjk' => '02.845.822.2-046.000',
            'namapimpinanppjk' => '',
            'alamatppjk' => 'RUKAN ARTHA GADING NIAGA BLOK H NO 11 RT.000 RW.000 KELAPA GADING BARAT,KELAPA GADING JAKARTA UTARA,DKI JAKARTA',
            'telppjk' => '( 021 ) 33149701 / ( 021 ) 89836776',
        ]);
        DB::table('forwader')->insert([
            'namappjk' => 'PT. YUSEN LOGISTICS INDONESIA',
            'npwpppjk' => '01.331.186.5-058.000',
            'namapimpinanppjk' => 'Waini Frans',
            'alamatppjk' => 'Kawasan Industri MM2100, Blok EE-4, Danau Indah Cikarang Barat, Bekasi, Jawa Barat',
            'telppjk' => '021-8981020 / 8980276',
        ]);
        DB::table('forwader')->insert([
            'namappjk' => 'BIROTIKA',
            'npwpppjk' => '',
            'namapimpinanppjk' => '',
            'alamatppjk' => 'Mulia Business Park, Building F Jl MT Haryono Kav. 58 - 60 Jakarta 12780',
            'telppjk' => '62-21-7917 3333',
        ]);
    }
}
