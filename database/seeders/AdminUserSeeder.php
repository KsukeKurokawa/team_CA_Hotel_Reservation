<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// モデルを宣言
use App\Models\User;
// Hashを使う関数を宣言
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '管理者',
            'phone' => '00000000000',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
