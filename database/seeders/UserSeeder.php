<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'kesiswaan', 'guru bk', 'siswa', 'kepala sekolah', 'wali kelas'];

        foreach ($roles as $index => $role) {
            User::create([
                'name' => ucfirst($role),
                'nip' => '19876543210' . str_pad($index + 1, 3, '0', STR_PAD_LEFT), // contoh NIP
                'email' => str_replace(' ', '_', $role) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => $role,
            ]);
        }
    }
}
