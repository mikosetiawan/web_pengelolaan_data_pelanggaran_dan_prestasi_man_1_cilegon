<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'nis' => '2025001',
                'name' => 'Ahmad Fathurrahman',
                'class' => 'X IPA 1',
                'gender' => 'L',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No.10, Bandung',
                'father_name' => 'Budi Rahman',
                'father_occupation' => 'Pegawai Negeri',
                'father_phone' => '081298765432',
                'father_address' => 'Jl. Merdeka No.10, Bandung',
                'mother_name' => 'Siti Aminah',
                'mother_occupation' => 'Ibu Rumah Tangga',
                'mother_phone' => '081212345678',
                'mother_address' => 'Jl. Merdeka No.10, Bandung',
                'guardian_name' => 'Tidak Ada',
                'guardian_occupation' => '-',
                'guardian_phone' => '-',
                'guardian_address' => '-',
            ],
            [
                'nis' => '2025002',
                'name' => 'Rina Maharani',
                'class' => 'XI IPS 2',
                'gender' => 'P',
                'phone' => '081322334455',
                'address' => 'Jl. Sukajadi No.45, Bandung',
                'father_name' => 'Joko Santoso',
                'father_occupation' => 'Wiraswasta',
                'father_phone' => '081355566677',
                'father_address' => 'Jl. Sukajadi No.45, Bandung',
                'mother_name' => 'Dewi Lestari',
                'mother_occupation' => 'Guru',
                'mother_phone' => '081388899900',
                'mother_address' => 'Jl. Sukajadi No.45, Bandung',
                'guardian_name' => 'Tidak Ada',
                'guardian_occupation' => '-',
                'guardian_phone' => '-',
                'guardian_address' => '-',
            ],
            [
                'nis' => '2025003',
                'name' => 'Andi Saputra',
                'class' => 'XII IPA 3',
                'gender' => 'L',
                'phone' => '081399988877',
                'address' => 'Jl. Setiabudi No.88, Bandung',
                'father_name' => 'Supriyadi',
                'father_occupation' => 'Petani',
                'father_phone' => '081344455566',
                'father_address' => 'Jl. Setiabudi No.88, Bandung',
                'mother_name' => 'Rohana',
                'mother_occupation' => 'Ibu Rumah Tangga',
                'mother_phone' => '081377766655',
                'mother_address' => 'Jl. Setiabudi No.88, Bandung',
                'guardian_name' => 'Pak Ujang',
                'guardian_occupation' => 'Paman',
                'guardian_phone' => '081311122233',
                'guardian_address' => 'Jl. Setiabudi No.88, Bandung',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
