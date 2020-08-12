<?php

use App\Model\MstSupplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstSupplier::query()->truncate();

        MstSupplier::create(['kode_supplier' => 'SMB', 'nama_supplier' => 'PT. Sumber Makan Baru']);
        MstSupplier::create(['kode_supplier' => 'AGJ', 'nama_supplier' => 'Agen Jago']);
        MstSupplier::create(['kode_supplier' => 'CVT', 'nama_supplier' => 'CV. Value Team', 'pic' => 'Agat']);
    }
}
