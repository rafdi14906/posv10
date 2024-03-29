<?php

use App\Model\MstBarang;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstBarang::query()->truncate();

        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'BLT1', 'nama_barang' => 'Bolt Repack 1 Kg', 'satuan' => 'Pcs', 'harga' => 18000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'MEO0', 'nama_barang' => 'Meo Tuna Repack 500 Gr', 'satuan' => 'Pcs', 'harga' => 15000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'MEO1', 'nama_barang' => 'Meo Tuna Repack 1 Kg', 'satuan' => 'Pcs', 'harga' => 25000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'MEO2', 'nama_barang' => 'Meo Tuna 500 Gr', 'satuan' => 'Pcs', 'harga' => 20000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'MEO3', 'nama_barang' => 'Meo Tuna 1.2 Kg', 'satuan' => 'Pcs', 'harga' => 30000]);
        MstBarang::create(['kategori_id' => 2, 'kode_barang' => 'CKR1', 'nama_barang' => 'Scratch Kucing S', 'satuan' => 'Pcs', 'harga' => 45000]);
        MstBarang::create(['kategori_id' => 3, 'kode_barang' => 'RBT1', 'nama_barang' => 'Rabit Repack 1 Kg', 'satuan' => 'Pcs', 'harga' => 15000]);
        MstBarang::create(['kategori_id' => 3, 'kode_barang' => 'RBT0', 'nama_barang' => 'Rabit Repack 500 Gr', 'satuan' => 'Pcs', 'harga' => 10000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'WHS0', 'nama_barang' => 'Whiskas Tuna Repack 500 Gr', 'satuan' => 'Pcs', 'harga' => 16000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'WHS1', 'nama_barang' => 'Whiskas Tuna Repack 1 Kg', 'satuan' => 'Pcs', 'harga' => 26000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'WHS2', 'nama_barang' => 'Whiskas Tuna 500 Gr', 'satuan' => 'Pcs', 'harga' => 21000]);
        MstBarang::create(['kategori_id' => 1, 'kode_barang' => 'WHS3', 'nama_barang' => 'Whiskas Tuna 1 Kg', 'satuan' => 'Pcs', 'harga' => 31000]);
    }
}
