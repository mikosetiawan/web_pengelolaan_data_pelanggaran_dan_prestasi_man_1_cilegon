<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'user'])->get();
        $students = Student::where('status', 'active')->orderBy('name')->get();
        return view('pages.grade.index', compact('grades', 'students'));
    }

    public function store(Request $request)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['wali kelas', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menambahkan nilai.'
            ], 403);
        }

        Log::info('Store Grade Request:', $request->all());

        $validated = $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'major' => 'required|in:IPA,IPS',
                'academic_year' => 'required|regex:/^\d{4}-\d{4}$/',
                'semester' => 'required|integer|in:1,2,3,4,5',
                'average_grade' => 'required|numeric|between:0,100',
            ],
            [
                'student_id.required' => 'Siswa wajib dipilih.',
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'major.required' => 'Jurusan wajib dipilih.',
                'major.in' => 'Jurusan harus IPA atau IPS.',
                'academic_year.required' => 'Tahun pelajaran wajib diisi.',
                'academic_year.regex' => 'Format tahun pelajaran harus YYYY-YYYY (contoh: 2020-2021).',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.in' => 'Semester harus antara 1 sampai 5.',
                'average_grade.required' => 'Nilai rata-rata wajib diisi.',
                'average_grade.numeric' => 'Nilai rata-rata harus berupa angka.',
                'average_grade.between' => 'Nilai rata-rata harus antara 0 dan 100.',
            ]
        );

        try {
            DB::beginTransaction();

            $grade = Grade::create([
                'student_id' => $validated['student_id'],
                'user_id' => Auth::id(),
                'major' => $validated['major'],
                'academic_year' => $validated['academic_year'],
                'semester' => $validated['semester'],
                'average_grade' => (float) $validated['average_grade'], // Ensure float conversion
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Nilai siswa berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store grade: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan nilai: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['wali kelas', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk memperbarui nilai.'
            ], 403);
        }

        Log::info('Update Grade Request:', $request->all());

        $validated = $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'major' => 'required|in:IPA,IPS',
                'academic_year' => 'required|regex:/^\d{4}-\d{4}$/',
                'semester' => 'required|integer|in:1,2,3,4,5',
                'average_grade' => 'required|numeric|between:0,100',
            ],
            [
                'student_id.required' => 'Siswa wajib dipilih.',
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'major.required' => 'Jurusan wajib dipilih.',
                'major.in' => 'Jurusan harus IPA atau IPS.',
                'academic_year.required' => 'Tahun pelajaran wajib diisi.',
                'academic_year.regex' => 'Format tahun pelajaran harus YYYY-YYYY (contoh: 2020-2021).',
                'semester.required' => 'Semester wajib dipilih.',
                'semester.in' => 'Semester harus antara 1 sampai 5.',
                'average_grade.required' => 'Nilai rata-rata wajib diisi.',
                'average_grade.numeric' => 'Nilai rata-rata harus berupa angka.',
                'average_grade.between' => 'Nilai rata-rata harus antara 0 dan 100.',
            ]
        );

        $grade = Grade::findOrFail($id);

        try {
            DB::beginTransaction();

            $grade->update([
                'student_id' => $validated['student_id'],
                'user_id' => Auth::id(),
                'major' => $validated['major'],
                'academic_year' => $validated['academic_year'],
                'semester' => $validated['semester'],
                'average_grade' => (float) $validated['average_grade'], // Ensure float conversion
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Nilai siswa berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update grade: ' . $e->getMessage(), [
                'request' => $request->all(),
                'exception' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui nilai: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['wali kelas', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk menghapus nilai.'
            ], 403);
        }

        try {
            $grade = Grade::findOrFail($id);
            DB::beginTransaction();

            $grade->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Nilai siswa berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete grade: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus nilai: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function report()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['wali kelas', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki izin untuk melihat laporan.');
        }

        try {
            // Fetch IPA students with their latest grades, ranked by average_grade
            $ipaStudents = Grade::where('major', 'IPA')
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.status', 'active')
                ->select('students.name', 'students.nis', 'students.class', 'grades.average_grade', 'grades.semester', 'grades.academic_year')
                ->orderBy('grades.average_grade', 'desc')
                ->get()
                ->map(function ($item, $index) {
                    $item->rank = $index + 1;
                    return $item;
                });

            // Fetch IPS students with their latest grades, ranked by average_grade
            $ipsStudents = Grade::where('major', 'IPS')
                ->join('students', 'grades.student_id', '=', 'students.id')
                ->where('students.status', 'active')
                ->select('students.name', 'students.nis', 'students.class', 'grades.average_grade', 'grades.semester', 'grades.academic_year')
                ->orderBy('grades.average_grade', 'desc')
                ->get()
                ->map(function ($item, $index) {
                    $item->rank = $index + 1;
                    return $item;
                });

            return view('pages.grade.report', compact('ipaStudents', 'ipsStudents'));
        } catch (\Exception $e) {
            Log::error('Failed to generate grade report: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
            ]);
            return redirect()->route('dashboard')->with('error', 'Gagal menghasilkan laporan: ' . $e->getMessage());
        }
    }


     public function rankingReport()
    {
        // Fetch students with their grades for semesters 1-5
        $students = Student::with(['grades' => function ($query) {
            $query->whereIn('semester', [1, 2, 3, 4, 5]);
        }])->get();

        // Initialize arrays for MIPA and IPS rankings
        $mipaRankings = [];
        $ipsRankings = [];

        foreach ($students as $student) {
            // Calculate average grade for semesters 1-5
            $grades = $student->grades->whereIn('semester', [1, 2, 3, 4, 5]);
            $averageGrade = $grades->isNotEmpty() ? $grades->avg('average_grade') : 0;

            if ($averageGrade > 0) {
                $rankingData = [
                    'student_id' => $student->id,
                    'nis' => $student->nis,
                    'name' => $student->name,
                    'class' => $student->class,
                    'major' => $grades->first()->major ?? 'Unknown',
                    'average_grade' => round($averageGrade, 2),
                ];

                // Group by major
                if (strtoupper($rankingData['major']) == 'MIPA') {
                    $mipaRankings[] = $rankingData;
                } elseif (strtoupper($rankingData['major']) == 'IPS') {
                    $ipsRankings[] = $rankingData;
                }
            }
        }

        // Sort rankings by average grade in descending order
        usort($mipaRankings, function ($a, $b) {
            return $b['average_grade'] <=> $a['average_grade'];
        });

        usort($ipsRankings, function ($a, $b) {
            return $b['average_grade'] <=> $a['average_grade'];
        });

        // Add rank numbers
        foreach ($mipaRankings as $index => &$ranking) {
            $ranking['rank'] = $index + 1;
        }

        foreach ($ipsRankings as $index => &$ranking) {
            $ranking['rank'] = $index + 1;
        }

        return view('pages.grade.ranking', [
            'title' => 'Academic Ranking Report',
            'mipaRankings' => $mipaRankings,
            'ipsRankings' => $ipsRankings,
        ]);
    }


}