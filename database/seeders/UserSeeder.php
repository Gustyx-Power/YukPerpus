<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'level' => 'admin',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Admin No. 1',
            ]
        );

        // Create Petugas
        User::firstOrCreate(
            ['email' => 'petugas@petugas.com'],
            [
                'nama' => 'Petugas Perpustakaan',
                'password' => Hash::make('petugas123'),
                'level' => 'petugas',
                'no_hp' => '081234567891',
                'alamat' => 'Jl. Petugas No. 1',
            ]
        );

        // Create Sample Member
        User::firstOrCreate(
            ['email' => 'anggota@anggota.com'],
            [
                'nama' => 'Anggota Perpustakaan',
                'password' => Hash::make('anggota123'),
                'level' => 'anggota',
                'no_hp' => '081234567892',
                'alamat' => 'Jl. Anggota No. 1',
            ]
        );
    }
} 