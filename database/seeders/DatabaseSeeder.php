<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Dummy Akun Admin / Guru
        User::create([
            'name' => 'Guru Budi',
            'email' => 'admin@arunika.com',
            'password' => Hash::make('rahasia123'),
            'role' => 'admin',
            'class_code' => 'ARN001',
            'school_name' => 'SDN Arunika 1 - Kelas 1A',
        ]);

        // 2. Data Dummy Akun Orang Tua / Wali Murid
        User::create([
            'name' => 'Orang Tua Aaliyah',
            'email' => 'ortu@arunika.com',
            'password' => Hash::make('rahasia123'),
            'role' => 'parent',
            'child_name' => 'Aaliyah Kamelia Puspita',
            'class_age' => 'Kelas 2 (7-8 Tahun)',
            'class_code' => 'ARN001',
            'school_name' => 'SDN Arunika 1 - Kelas 1A',
        ]);
    }
}
