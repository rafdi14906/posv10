<?php

use App\Model\MstKategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstKategori::query()->truncate();

        MstKategori::create(['nama_kategori' => 'Makanan Kucing']);
        MstKategori::create(['nama_kategori' => 'Mainan Kucing']);
        MstKategori::create(['nama_kategori' => 'Makanan Kelinci']);
    }
}
