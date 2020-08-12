<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();
        
        User::create([
            'roles_id' => 1,
            'name' => 'Hendry',
            'username' => 'sa',
            'password' => bcrypt('admin'),
            'email' => 'hendryrafdi@gmail.com'
        ]);

        User::create([
            'roles_id' => 2,
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'admin@gmail.com'
        ]);

        User::create([
            'roles_id' => 3,
            'name' => 'Kasir',
            'username' => 'kasir',
            'password' => bcrypt('kasir'),
            'email' => 'kasir@gmail.com'
        ]);
    }
}
