<?php

namespace Database\Seeders;

use App\Models\Violation;
use Illuminate\Database\Seeder;

class ViolationSeeder extends Seeder
{
    public function run(): void
    {
        $violations = [
            ['nama_pelanggaran' => 'Terlambat masuk sekolah', 'skor' => 5],
            ['nama_pelanggaran' => 'Terlambat masuk kelas setelah jam istirahat', 'skor' => 5],
            ['nama_pelanggaran' => 'Keluar dalam PBM dengan izin atau tidak dan tidak kembali', 'skor' => 15],
            ['nama_pelanggaran' => 'Keluar kelas pada saat belajar/pergantian jam pelajaran tanpa izin', 'skor' => 15],
            ['nama_pelanggaran' => 'Keluar dari lingkungan sekolah tanpa izin', 'skor' => 15],
            ['nama_pelanggaran' => 'Siswa tidak masuk sekolah tanpa keterangan', 'skor' => 20],
            ['nama_pelanggaran' => 'Masuk/Keluar dari lingkungan sekolah tidak melewati pintu yang semestinya', 'skor' => 20],
            ['nama_pelanggaran' => 'Siswa tidak masuk karena izin lebih dari 5 kali dalam satu semester', 'skor' => 20],
            ['nama_pelanggaran' => 'Siswa tidak masuk sekolah dengan membuat keterangan palsu', 'skor' => 20],
            ['nama_pelanggaran' => 'Siswa tidur di kelas pada jam sekolah/pada saat PBM', 'skor' => 20],
            ['nama_pelanggaran' => 'Tidak mengikuti upacara bendera/kegiatan jum’at pagi', 'skor' => 20],
            ['nama_pelanggaran' => 'Tidak mengikuti kerja bakti', 'skor' => 10],
            ['nama_pelanggaran' => 'Membuat keributan di kelas pada saat PBM', 'skor' => 25],
            ['nama_pelanggaran' => 'Tidak tertib mengikuti kegiatan sekolah', 'skor' => 20],
            ['nama_pelanggaran' => 'Masuk ruang kepala sekolah/TU/guru tanpa izin', 'skor' => 10],
            ['nama_pelanggaran' => 'Menempatkan kendaraan diluar tempat parkir yang ditentukan', 'skor' => 25],
            ['nama_pelanggaran' => 'Memasukkan/mengeluarkan kendaraan dengan tidak tertib', 'skor' => 20],
            ['nama_pelanggaran' => 'Memarkir kendaraan tidak rapi', 'skor' => 5],
            ['nama_pelanggaran' => 'Membayar iuran sekolah lewat tanggal 10 tiap bulan', 'skor' => 5],
            ['nama_pelanggaran' => 'Makan/minum pada saat PBM berlangsung', 'skor' => 10],
            ['nama_pelanggaran' => 'Membawa peralatan make up', 'skor' => 10],
            ['nama_pelanggaran' => 'Membuang sampah tidak pada tempatnya', 'skor' => 15],
            ['nama_pelanggaran' => 'Menggunakan barang sekolah/teman tanpa izin', 'skor' => 10],
            ['nama_pelanggaran' => 'Mengotori/merusak/menghilangkan benda milik sekolah/orang lain', 'skor' => 20],
            ['nama_pelanggaran' => 'Memberikan keterangan palsu/berbohong', 'skor' => 25],
            ['nama_pelanggaran' => 'Membawa rokok/merokok selama berseragam sekolah', 'skor' => 25],
            ['nama_pelanggaran' => 'Mengaktifkan HP pada jam sekolah', 'skor' => 10],
            ['nama_pelanggaran' => 'Mengaktifkan HP & mengoperasikan program yang mengganggu', 'skor' => 25],
            ['nama_pelanggaran' => 'Mengedarkan, merekam atau menyimpan foto-foto pornografi', 'skor' => 100],
            ['nama_pelanggaran' => 'Membawa senjata tajam ke lingkungan sekolah', 'skor' => 50],
            ['nama_pelanggaran' => 'Membawa/menggunakan obat/minuman terlarang', 'skor' => 100],
            ['nama_pelanggaran' => 'Berkelahi di lingkungan/diluar lingkungan sekolah', 'skor' => 100],
            ['nama_pelanggaran' => 'Berbicara kasar/tidak sopan pada guru/karyawan', 'skor' => 100],
            ['nama_pelanggaran' => 'Melakukan tindakan amoral di lingkungan sekolah', 'skor' => 100],
            ['nama_pelanggaran' => 'Melakukan tindakan amoral di luar lingkungan sekolah', 'skor' => 100],
            ['nama_pelanggaran' => 'Terlibat pergaulan bebas dan segala akibatnya', 'skor' => 100],
            ['nama_pelanggaran' => 'Segala sesuatu tindakan yang termasuk tindak pidana', 'skor' => 100],
            ['nama_pelanggaran' => 'Bertato di badan, tindik, memakai persing', 'skor' => 100],
            ['nama_pelanggaran' => 'Memakai seragam sekolah tidak sesuai dengan ketentuan', 'skor' => 15],
            ['nama_pelanggaran' => 'Tidak memakai pakaian praktik pada saat praktik', 'skor' => 15],
            ['nama_pelanggaran' => 'Tidak berpakaian olahraga pada saat olahraga', 'skor' => 15],
            ['nama_pelanggaran' => 'Berpakaian praktik di luar jadwal yang ditentukan', 'skor' => 5],
            ['nama_pelanggaran' => 'Memakai seragam/baju olahraga tidak rapi', 'skor' => 10],
            ['nama_pelanggaran' => 'Siswa putri memakai baju ketat/rok di atas lutut', 'skor' => 20],
            ['nama_pelanggaran' => 'Siswa putra memakai celana yang bagian bawahnya lebar', 'skor' => 10],
            ['nama_pelanggaran' => 'Memakai lengan baju dilipat', 'skor' => 5],
            ['nama_pelanggaran' => 'Siswa putri memakai perhiasan berlebihan', 'skor' => 10],
            ['nama_pelanggaran' => 'Siswa putra memakai aksesoris menyerupai putri', 'skor' => 20],
            ['nama_pelanggaran' => 'Rambut tidak SKI 1 bagi siswa putra', 'skor' => 20],
            ['nama_pelanggaran' => 'Rambut diwarna/di cat/highlight', 'skor' => 25],
            ['nama_pelanggaran' => 'Siswa berkuku panjang/di cat', 'skor' => 25],
        ];

        foreach ($violations as &$violation) {
            $score = $violation['skor'];

            if ($score > 75) {
                $violation['kategori'] = 'berat';
            } elseif ($score > 50) {
                $violation['kategori'] = 'sedang';
            } else {
                $violation['kategori'] = 'ringan';
            }

            Violation::create($violation);
        }
    }
}
