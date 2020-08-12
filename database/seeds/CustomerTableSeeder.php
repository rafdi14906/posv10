<?php

use App\Model\MstCustomer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MstCustomer::query()->truncate();

        MstCustomer::create(['kode_customer' => 'DDL1', 'nama_customer' => 'Doddy Limbong']);
        MstCustomer::create(['kode_customer' => 'ADO1', 'nama_customer' => 'Adam Okunami']);
        MstCustomer::create(['kode_customer' => 'AGS', 'nama_customer' => 'PT. Auto Gear Shift', 'pic' => 'Joni']);
    }
}
