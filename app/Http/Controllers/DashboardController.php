<?php
// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Achievement;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah data untuk kartu dashboard
        $jumlahPrestasi = Achievement::count();
        $jumlahPelanggaran = Pelanggaran::count();
        $jumlahSiswa = Student::count();
        $jumlahStaff = User::whereIn('role', ['kesiswaan', 'guru bk', 'guru pembina', 'wali kelas'])->count();

        // Menentukan jumlah data per halaman
        $perPage = $request->input('per_page', 10); // Default 10 data per halaman

        // Menggabungkan data pelanggaran dan prestasi menggunakan union
        $pelanggarans = Pelanggaran::select([
            'students.nis as student_id',
            'students.name as student_name',
            'violations.nama_pelanggaran as category',
            'pelanggarans.points',
            'pelanggarans.date as created_at',
            'pelanggarans.updated_at',
            DB::raw('"Pelanggaran" as status')
        ])
        ->join('students', 'pelanggarans.student_id', '=', 'students.id')
        ->join('violations', 'pelanggarans.violation_id', '=', 'violations.id');

        $achievements = Achievement::select([
            'students.nis as student_id',
            'students.name as student_name',
            'achievement_types.name as category',
            DB::raw('NULL as points'), // Prestasi tidak memiliki poin, sesuaikan jika ada
            'achievements.date as created_at',
            'achievements.updated_at',
            DB::raw('"Prestasi" as status')
        ])
        ->join('students', 'achievements.student_id', '=', 'students.id')
        ->join('achievement_types', 'achievements.achievement_type_id', '=', 'achievement_types.id');

        // Menggabungkan dan melakukan pagination
        $data = $pelanggarans->union($achievements)->orderBy('created_at', 'desc')->paginate($perPage);

        return view('dashboard', compact('jumlahPrestasi', 'jumlahPelanggaran', 'jumlahSiswa', 'jumlahStaff', 'data', 'perPage'));
    }
}