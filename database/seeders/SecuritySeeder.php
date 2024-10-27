<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Security;

class SecuritySeeder extends Seeder
{
    public function run()
    {
        Security::create([
            'name' => 'Security',
            'email' => 'leanalegre123@gmail.com',
            'password' => 'LeanAlegre123', 
            
        ]);
    }
}
