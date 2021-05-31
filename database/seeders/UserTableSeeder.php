<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Olger Campos',
            'email' => 'olgercamposval@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '86600257',
            'address' => 'Sabalito',
            'role' => 'admin'
        ]);
    }
}
