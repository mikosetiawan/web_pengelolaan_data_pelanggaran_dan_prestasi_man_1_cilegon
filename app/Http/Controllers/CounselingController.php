<?php

namespace App\Http\Controllers;

use App\Models\Counseling;
use App\Models\Student;
use App\Models\Violation;
use App\Models\User;
use App\Models\Spo;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class CounselingController extends Controller
{
    public function index()
    {
        // Fetch counselings with relationships
        $counselings = Counseling::with(['student', 'violation', 'counselor'])->get();
        
        // Fetch students with SPO and total points >= 100
        $students = Student::whereHas('pelanggarans', function ($query) {
            $query->whereIn('id', function ($subQuery) {
                $subQuery->select('pelanggaran_id')
                    ->from('spos')
                    ->whereNotNull('pelanggaran_id');
            });
        })->with(['pelanggarans' => function ($query) {
            $query->select('student_id', DB::raw('SUM(points) as total_points'))
                ->groupBy('student_id')
                ->having('total_points', '>=', 100);
        }])->orderBy('name')->get();

        // Fetch violations and counselors
        $violations = Violation::orderBy('nama_pelanggaran')->get();
        $counselors = User::whereIn('role', ['guru bk', 'kesiswaan'])->orderBy('name')->get();

        // Map student IDs to their SPO-related violation IDs
        $studentViolations = [];
        foreach ($students as $student) {
            $spo = Spo::where('student_id', $student->id)->first();
            if ($spo && $spo->pelanggaran) {
                $studentViolations[$student->id] = $spo->pelanggaran->violation_id;
            }
        }

        return view('pages.counseling.index', compact('counselings', 'students', 'violations', 'counselors', 'studentViolations'));
    }

    public function store(Request $request)
    {
        Log::info('Store Counseling Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'violation_id' => 'required|exists:violations,id',
                'solution' => 'nullable|string|max:1000',
                'counseling_date' => 'required|date|before_or_equal:today',
                'counselor_id' => 'required|exists:users,id',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'violation_id.required' => 'Jenis pelanggaran wajib dipilih.',
                'violation_id.exists' => 'Pelanggaran tidak ditemukan.',
                'solution.max' => 'Solusi tidak boleh melebihi 1000 karakter.',
                'counseling_date.required' => 'Tanggal konseling wajib diisi.',
                'counseling_date.before_or_equal' => 'Tanggal konseling tidak boleh di masa depan.',
                'counselor_id.exists' => 'Guru konseling tidak ditemukan.',
            ]
        );

        try {
            DB::beginTransaction();

            Counseling::create([
                'student_id' => $request->student_id,
                'violation_id' => $request->violation_id,
                'solution' => $request->solution,
                'counseling_date' => $request->counseling_date,
                'counselor_id' => $request->counselor_id,
            ]);

            DB::commit();

            Alert::success('Berhasil!', 'Data konseling berhasil ditambahkan.');
            return redirect()->route('counseling.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store counseling: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal menambahkan data konseling: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Update Counseling Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'violation_id' => 'required|exists:violations,id',
                'solution' => 'nullable|string|max:1000',
                'counseling_date' => 'required|date|before_or_equal:today',
                'counselor_id' => 'required|exists:users,id',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'violation_id.required' => 'Jenis pelanggaran wajib dipilih.',
                'violation_id.exists' => 'Pelanggaran tidak ditemukan.',
                'solution.max' => 'Solusi tidak boleh melebihi 1000 karakter.',
                'counseling_date.required' => 'Tanggal konseling wajib diisi.',
                'counseling_date.before_or_equal' => 'Tanggal konseling tidak boleh di masa depan.',
                'counselor_id.exists' => 'Guru konseling tidak ditemukan.',
            ]
        );

        $counseling = Counseling::findOrFail($id);

        try {
            DB::beginTransaction();

            $counseling->update([
                'student_id' => $request->student_id,
                'violation_id' => $request->violation_id,
                'solution' => $request->solution,
                'counseling_date' => $request->counseling_date,
                'counselor_id' => $request->counselor_id,
            ]);

            DB::commit();

            Alert::success('Berhasil!', 'Data konseling berhasil diperbarui.');
            return redirect()->route('counseling.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update counseling: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal memperbarui data konseling: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $counseling = Counseling::findOrFail($id);
            DB::beginTransaction();

            $counseling->delete();

            DB::commit();

            Alert::success('Berhasil!', 'Data konseling berhasil dihapus.');
            return redirect()->route('counseling.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete counseling: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal menghapus data konseling: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}