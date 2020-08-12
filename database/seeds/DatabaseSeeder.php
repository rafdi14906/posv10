<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SettingTableSeeder::class);
        $this->call(KategoriTableSeeder::class);
        $this->call(BarangTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
    }
}
