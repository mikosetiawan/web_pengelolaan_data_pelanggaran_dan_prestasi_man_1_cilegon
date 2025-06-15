<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Student;
use App\Models\Violation;
use App\Models\Spo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Twilio\Rest\Client;

class PelanggaranController extends Controller
{
    /**
     * Send WhatsApp notification using Twilio
     */
    private function sendWhatsAppNotification($to, $message)
    {
        try {
            $twilioSid = env('TWILIO_SID');
            $twilioAuthToken = env('TWILIO_AUTH_TOKEN');
            $twilioWhatsAppFrom = env('TWILIO_WHATSAPP_FROM');

            $twilio = new Client($twilioSid, $twilioAuthToken);

            $twilio->messages->create($to, [
                'from' => $twilioWhatsAppFrom,
                'body' => $message,
            ]);

            Log::info('WhatsApp notification sent to ' . $to . ': ' . $message);
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp notification: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $pelanggarans = Pelanggaran::with(['student', 'violation'])->get();
        $students = Student::orderBy('name')->where('status', 'active')->get();
        $violations = Violation::orderBy('nama_pelanggaran')->get();
        return view('pages.pelanggaran.index', compact('pelanggarans', 'students', 'violations'));
    }

    public function store(Request $request)
    {
        Log::info('Store Pelanggaran Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'violation_id' => 'required|exists:violations,id',
                'description' => 'nullable|string',
                'sanksi' => 'nullable|string|max:1000',
                'date' => 'required|date|before_or_equal:today',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'violation_id.required' => 'Jenis pelanggaran wajib dipilih.',
                'violation_id.exists' => 'Pelanggaran tidak ditemukan.',
                'sanksi.max' => 'Sanksi tidak boleh melebihi 1000 karakter.',
                'date.required' => 'Tanggal wajib diisi.',
                'date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
            ],
        );

        // Check for duplicate violation
        if (Pelanggaran::where('student_id', $request->student_id)->where('violation_id', $request->violation_id)->where('date', $request->date)->exists()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Pelanggaran untuk siswa ini pada tanggal dan jenis tersebut sudah ada.',
                ],
                422,
            );
        }

        try {
            DB::beginTransaction();

            $violation = Violation::findOrFail($request->violation_id);
            $newPoints = $violation->skor;
            $student = Student::findOrFail($request->student_id);

            // Calculate total points including the new violation
            $totalPoints = Pelanggaran::where('student_id', $request->student_id)->sum('points') + $newPoints;

            // Check if student is already inactive
            if ($student->status === 'inactive') {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Siswa {$student->name} sudah berstatus tidak aktif. Tidak dapat menambahkan pelanggaran baru.",
                        'totalPoints' => $totalPoints,
                        'studentName' => $student->name,
                    ],
                    422,
                );
            }

            // Create Pelanggaran record
            $pelanggaran = Pelanggaran::create([
                'student_id' => $request->student_id,
                'violation_id' => $request->violation_id,
                'points' => $newPoints,
                'description' => $request->description,
                'sanksi' => $request->sanksi,
                'date' => $request->date,
            ]);

            // Determine SPO level based on total points
            $spoLevel = null;
            if ($totalPoints >= 25 && $totalPoints < 50) {
                $spoLevel = 'spo_1';
            } elseif ($totalPoints >= 50 && $totalPoints < 75) {
                $spoLevel = 'spo_2';
            } elseif ($totalPoints >= 75 && $totalPoints < 100) {
                $spoLevel = 'spo_3';
            }

            // Check if student already has an SPO
            $existingSpo = Spo::where('student_id', $request->student_id)->orderBy('id', 'desc')->first();
            if ($existingSpo) {
                // Define SPO level hierarchy for comparison
                $spoHierarchy = ['spo_1' => 1, 'spo_2' => 2, 'spo_3' => 3];
                if ($spoLevel && isset($spoHierarchy[$existingSpo->level_spo]) && $spoHierarchy[$existingSpo->level_spo] >= $spoHierarchy[$spoLevel]) {
                    DB::commit();
                    return response()->json(
                        [
                            'status' => 'success',
                            'message' => 'Pelanggaran berhasil ditambahkan, tetapi SPO tidak diterbitkan karena siswa sudah memiliki SPO dengan level yang sama atau lebih tinggi.',
                            'totalPoints' => $totalPoints,
                            'studentName' => $student->name,
                        ],
                        200,
                    );
                }
            }

            // Handle case when total points >= 100
            if ($totalPoints >= 100) {
                // Set student status to inactive
                $student->update(['status' => 'inactive']);
                DB::commit();
                return response()->json(
                    [
                        'status' => 'warning',
                        'message' => "Peringatan: Siswa {$student->name} telah mencapai total poin pelanggaran {$totalPoints} (>= 100). Status siswa telah diubah menjadi tidak aktif. Tidak ada SPO yang diterbitkan.",
                        'totalPoints' => $totalPoints,
                        'studentName' => $student->name,
                    ],
                    200,
                );
            }

            // Create SPO if applicable
            if ($spoLevel) {
                $wakaKesiswaan = \App\Models\User::where('role', 'kesiswaan')->first();
                $waliKelas = \App\Models\User::where('role', 'wali kelas')->first();
                $kepalaSekolah = \App\Models\User::where('role', 'kepala sekolah')->first();

                $spo = Spo::create([
                    'student_id' => $request->student_id,
                    'pelanggaran_id' => $pelanggaran->id,
                    'user_id' => Auth::id(),
                    'sign_id_waka_siswa' => $wakaKesiswaan ? $wakaKesiswaan->id : null,
                    'sign_id_wali_kelas' => $waliKelas ? $waliKelas->id : null,
                    'sign_id_kepala_sekolah' => $kepalaSekolah ? $kepalaSekolah->id : null,
                    'number_spo' => null,
                    'date_spo' => Carbon::tomorrow()->toDateString(),
                    'time_spo' => '08:00:00',
                    'level_spo' => $spoLevel,
                ]);

                // Generate SPO number
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $spoNumber = sprintf('%03d/%s/MAN-01/SPO/%s', $spo->id, $month, $year);
                $spo->update(['number_spo' => $spoNumber]);

                // Render SPO Document
                $spoHtml = view('pages.spo.report-spo', [
                    'student' => $student,
                    'spo' => $spo,
                    'pelanggaran' => $pelanggaran,
                    'totalPoints' => $totalPoints,
                    'date' => Carbon::today()->format('d F Y'),
                    'meetingDate' => Carbon::tomorrow()->format('l / d F Y'),
                    'meetingTime' => '08:00 WIB',
                    'meetingPlace' => 'MAN 1 Kota Cilegon',
                ])->render();

                // Send WhatsApp notification to test number
                $testNumber = 'whatsapp:+6285779178942';
                $message = "Assalamualaikum, informasi terkait nama siswa: {$student->name}, pelanggaran: {$violation->nama_pelanggaran}, skor: {$newPoints}, dikenakan SPO {$spoLevel} pada tanggal " . Carbon::tomorrow()->format('d F Y') . " pukul 08:00 WIB di MAN 1 Kota Cilegon.";
                $this->sendWhatsAppNotification($testNumber, $message);

                // Previous notification logic (commented out)
                /*
                if ($student->phone) {
                    $message = "Assalamualaikum, informasi terkait nama siswa: {$student->name}, pelanggaran: {$violation->nama_pelanggaran}, skor: {$newPoints}, dikenakan SPO {$spoLevel} pada tanggal " . Carbon::tomorrow()->format('d F Y') . " pukul 08:00 WIB di MAN 1 Kota Cilegon.";
                    $this->sendWhatsAppNotification($student->phone, $message);
                } else {
                    Log::warning("No parent phone number found for student {$student->name}.");
                }
                */

                DB::commit();
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => "Pelanggaran berhasil ditambahkan. SPO {$spoLevel} dengan nomor {$spoNumber} telah dibuat untuk siswa {$student->name}.",
                        'totalPoints' => $totalPoints,
                        'studentName' => $student->name,
                        'spoNumber' => $spoNumber,
                        'spoHtml' => $spoHtml,
                    ],
                    200,
                );
            }

            DB::commit();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Pelanggaran berhasil ditambahkan.',
                ],
                200,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store pelanggaran: ' . $e->getMessage());
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Gagal menambahkan pelanggaran: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Update Pelanggaran Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'violation_id' => 'required|exists:violations,id',
                'description' => 'nullable|string',
                'sanksi' => 'nullable|string|max:1000',
                'date' => 'required|date|before_or_equal:today',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'violation_id.required' => 'Jenis pelanggaran wajib dipilih.',
                'violation_id.exists' => 'Pelanggaran tidak ditemukan.',
                'sanksi.max' => 'Sanksi tidak boleh melebihi 1000 karakter.',
                'date.required' => 'Tanggal wajib diisi.',
                'date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
            ],
        );

        $pelanggaran = Pelanggaran::findOrFail($id);

        // Check for duplicate violation
        if (Pelanggaran::where('student_id', $request->student_id)->where('violation_id', $request->violation_id)->where('date', $request->date)->where('id', '!=', $id)->exists()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Pelanggaran untuk siswa ini pada tanggal dan jenis tersebut sudah ada.',
                ],
                422,
            );
        }

        try {
            DB::beginTransaction();

            $violation = Violation::findOrFail($request->violation_id);
            $student = Student::findOrFail($request->student_id);
            $newPoints = $violation->skor;

            // Check if student is inactive
            if ($student->status === 'inactive') {
                DB::rollBack();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => "Siswa {$student->name} sudah berstatus tidak aktif. Tidak dapat memperbarui pelanggaran.",
                        'totalPoints' => 0,
                        'studentName' => $student->name,
                    ],
                    422,
                );
            }

            // Calculate total points excluding the current pelanggaran
            $totalPoints = Pelanggaran::where('student_id', $request->student_id)->where('id', '!=', $id)->sum('points') + $newPoints;

            // Handle case when total points >= 100
            if ($totalPoints >= 100) {
                $student->update(['status' => 'inactive']);
                // Delete any associated SPO
                Spo::where('pelanggaran_id', $pelanggaran->id)->delete();
                $pelanggaran->update([
                    'student_id' => $request->student_id,
                    'violation_id' => $request->violation_id,
                    'points' => $newPoints,
                    'description' => $request->description,
                    'sanksi' => $request->sanksi,
                    'date' => $request->date,
                ]);
                DB::commit();
                return response()->json(
                    [
                        'status' => 'warning',
                        'message' => "Siswa {$student->name} telah mencapai total poin pelanggaran {$totalPoints} (>= 100). Status siswa diubah menjadi tidak aktif.",
                        'totalPoints' => $totalPoints,
                        'studentName' => $student->name,
                    ],
                    200,
                );
            }

            // Determine new SPO level
            $spoLevel = null;
            if ($totalPoints >= 25 && $totalPoints < 50) {
                $spoLevel = 'spo_1';
            } elseif ($totalPoints >= 50 && $totalPoints < 75) {
                $spoLevel = 'spo_2';
            } elseif ($totalPoints >= 75 && $totalPoints < 100) {
                $spoLevel = 'spo_3';
            }

            // Check existing SPO
            $existingSpo = Spo::where('student_id', $request->student_id)->orderBy('id', 'desc')->first();
            $spoHierarchy = ['spo_1' => 1, 'spo_2' => 2, 'spo_3' => 3];

            // Update pelanggaran
            $pelanggaran->update([
                'student_id' => $request->student_id,
                'violation_id' => $request->violation_id,
                'points' => $newPoints,
                'description' => $request->description,
                'sanksi' => $request->sanksi,
                'date' => $request->date,
            ]);

            // Handle SPO update or creation
            if ($spoLevel) {
                if ($existingSpo && $spoHierarchy[$existingSpo->level_spo] >= $spoHierarchy[$spoLevel]) {
                    DB::commit();
                    return response()->json(
                        [
                            'status' => 'success',
                            'message' => 'Pelanggaran berhasil diperbarui, tetapi SPO tidak diterbitkan karena siswa sudah memiliki SPO dengan level yang sama atau lebih tinggi.',
                            'totalPoints' => $totalPoints,
                            'studentName' => $student->name,
                        ],
                        200,
                    );
                }

                // Delete old SPO if it exists and create a new one
                Spo::where('pelanggaran_id', $pelanggaran->id)->delete();
                $wakaKesiswaan = \App\Models\User::where('role', 'kesiswaan')->first();
                $waliKelas = \App\Models\User::where('role', 'wali kelas')->first();
                $kepalaSekolah = \App\Models\User::where('role', 'kepala sekolah')->first();

                $spo = Spo::create([
                    'student_id' => $request->student_id,
                    'pelanggaran_id' => $pelanggaran->id,
                    'user_id' => Auth::id(),
                    'sign_id_waka_siswa' => $wakaKesiswaan ? $wakaKesiswaan->id : null,
                    'sign_id_wali_kelas' => $waliKelas ? $waliKelas->id : null,
                    'sign_id_kepala_sekolah' => $kepalaSekolah ? $kepalaSekolah->id : null,
                    'number_spo' => null,
                    'date_spo' => Carbon::tomorrow()->toDateString(),
                    'time_spo' => '08:00:00',
                    'level_spo' => $spoLevel,
                ]);

                // Generate SPO number
                $month = Carbon::now()->format('m');
                $year = Carbon::now()->format('Y');
                $spoNumber = sprintf('%03d/%s/MAN-01/SPO/%s', $spo->id, $month, $year);
                $spo->update(['number_spo' => $spoNumber]);

                // Render SPO Document
                $spoHtml = view('pages.spo.report-spo', [
                    'student' => $student,
                    'spo' => $spo,
                    'pelanggaran' => $pelanggaran,
                    'totalPoints' => $totalPoints,
                    'date' => Carbon::today()->format('d F Y'),
                    'meetingDate' => Carbon::tomorrow()->format('l / d F Y'),
                    'meetingTime' => '08:00 WIB',
                    'meetingPlace' => 'MAN 1 Kota Cilegon',
                ])->render();

                // Send WhatsApp notification to test number
                $testNumber = 'whatsapp:+6285779178942';
                $message = "Assalamualaikum, informasi terkait nama siswa: {$student->name}, pelanggaran: {$violation->nama_pelanggaran}, skor: {$newPoints}, dikenakan SPO {$spoLevel} pada tanggal " . Carbon::tomorrow()->format('d F Y') . " pukul 08:00 WIB di MAN 1 Kota Cilegon.";
                $this->sendWhatsAppNotification($testNumber, $message);

                // Previous notification logic (commented out) - production code
                /*
                if ($student->phone) {
                    $message = "Assalamualaikum, informasi terkait nama siswa: {$student->name}, pelanggaran: {$violation->nama_pelanggaran}, skor: {$newPoints}, dikenakan SPO {$spoLevel} pada tanggal " . Carbon::tomorrow()->format('d F Y') . " pukul 08:00 WIB di MAN 1 Kota C addilegon.";
                    $this->sendWhatsAppNotification($student->phone, $message);
                } else {
                    Log::warning("No parent phone number found for student {$student->name}.");
                }
                */

                DB::commit();
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => "Pelanggaran berhasil diperbarui. SPO {$spoLevel} dengan nomor {$spoNumber} telah dibuat untuk siswa {$student->name}.",
                        'totalPoints' => $totalPoints,
                        'studentName' => $student->name,
                        'spoNumber' => $spoNumber,
                        'spoHtml' => $spoHtml,
                    ],
                    200,
                );
            }

            // If no SPO is needed, delete any existing SPO for this pelanggaran
            Spo::where('pelanggaran_id', $pelanggaran->id)->delete();
            DB::commit();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Pelanggaran berhasil diperbarui.',
                    'totalPoints' => $totalPoints,
                    'studentName' => $student->name,
                ],
                200,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update pelanggaran: ' . $e->getMessage());
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Gagal memperbarui pelanggaran: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function destroy($id)
    {
        try {
            $pelanggaran = Pelanggaran::findOrFail($id);
            DB::beginTransaction();

            // Soft delete associated Spo records
            Spo::where('pelanggaran_id', $pelanggaran->id)->delete();

            // Soft delete the Pelanggaran record
            $pelanggaran->delete();

            DB::commit();

            return response()->json(['success' => 'Pelanggaran berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete pelanggaran: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus pelanggaran: ' . $e->getMessage()], 500);
        }
    }
}