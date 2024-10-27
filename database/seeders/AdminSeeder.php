<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Admin',
            'email' => 'acantos677@gmail.com',
            'password' => 'Acantos345', 
            'role' => 'Admin', 
        ]);
    }
}
