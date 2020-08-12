<?php

use App\Model\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::query()->truncate();
        
        Roles::create(['role' => 'Super Admin']);
        Roles::create(['role' => 'Admin']);
        Roles::create(['role' => 'Kasir']);
    }
}
