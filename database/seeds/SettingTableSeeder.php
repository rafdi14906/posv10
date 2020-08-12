<?php

use App\Model\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::query()->truncate();

        Setting::create(['nama_toko' => 'Toko Beta', 'alamat' => 'Jl. Raya Ciherang, No. 51', 'kel' => 'Sukatani', 'kec' => 'Tapos', 'kota' => 'Depok', 'kode_pos' => '16464', 'telp' => '021-88221002', 'email' => 'beta@gmail.com']);
    }
}
