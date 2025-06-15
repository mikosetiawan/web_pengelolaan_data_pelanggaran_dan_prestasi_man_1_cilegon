<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Student;
use App\Models\AchievementType;
use App\Models\AchievementAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::with(['student', 'achievementType', 'attachments'])->get();
        $students = Student::orderBy('name')->get();
        $achievementTypes = AchievementType::orderBy('name')->get();
        return view('pages.achievement.index', compact('achievements', 'students', 'achievementTypes'));
    }

    public function store(Request $request)
    {
        Log::info('Store Achievement Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'achievement_type_id' => 'required|exists:achievement_types,id',
                'title' => 'required|string|max:255',
                'date' => 'required|date|before_or_equal:today',
                'level' => 'nullable|string|max:100',
                'award' => 'nullable|string|max:255',
                'attachments.*' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:3072',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'achievement_type_id.required' => 'Jenis prestasi wajib dipilih.',
                'achievement_type_id.exists' => 'Jenis prestasi tidak ditemukan.',
                'title.required' => 'Judul prestasi wajib diisi.',
                'date.required' => 'Tanggal wajib diisi.',
                'date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
                'attachments.*.mimes' => 'File harus berupa PDF, JPEG, JPG, atau PNG.',
                'attachments.*.max' => 'Ukuran file maksimum adalah 3MB.',
            ]
        );

        try {
            DB::beginTransaction();

            $achievement = Achievement::create([
                'student_id' => $request->student_id,
                'achievement_type_id' => $request->achievement_type_id,
                'title' => $request->title,
                'date' => $request->date,
                'level' => $request->level,
                'award' => $request->award,
            ]);

            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('achievements', 'public');
                        AchievementAttachment::create([
                            'achievement_id' => $achievement->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                        ]);
                    }
                }
            }

            DB::commit();

            Alert::success('Berhasil!', 'Prestasi berhasil ditambahkan.');
            return redirect()->route('achievement.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store achievement: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal menambahkan prestasi: ' . $e->getMessage());
            return redirect()->route('achievement.index');
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Update Achievement Request:', $request->all());

        $request->validate(
            [
                'student_id' => 'required|exists:students,id',
                'achievement_type_id' => 'required|exists:achievement_types,id',
                'title' => 'required|string|max:255',
                'date' => 'required|date|before_or_equal:today',
                'level' => 'nullable|string|max:100',
                'award' => 'nullable|string|max:255',
                'attachments.*' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:3072',
            ],
            [
                'student_id.exists' => 'Siswa tidak ditemukan.',
                'achievement_type_id.required' => 'Jenis prestasi wajib dipilih.',
                'achievement_type_id.exists' => 'Jenis prestasi tidak ditemukan.',
                'title.required' => 'Judul prestasi wajib diisi.',
                'date.required' => 'Tanggal wajib diisi.',
                'date.before_or_equal' => 'Tanggal tidak boleh di masa depan.',
                'attachments.*.mimes' => 'File harus berupa PDF, JPEG, JPG, atau PNG.',
                'attachments.*.max' => 'Ukuran file maksimum adalah 3MB.',
            ]
        );

        $achievement = Achievement::findOrFail($id);

        try {
            DB::beginTransaction();

            $achievement->update([
                'student_id' => $request->student_id,
                'achievement_type_id' => $request->achievement_type_id,
                'title' => $request->title,
                'date' => $request->date,
                'level' => $request->level,
                'award' => $request->award,
            ]);

            if ($request->hasFile('attachments')) {
                // Delete existing attachments
                foreach ($achievement->attachments as $attachment) {
                    Storage::disk('public')->delete($attachment->file_path);
                    $attachment->delete();
                }

                // Store new attachments
                foreach ($request->file('attachments') as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('achievements', 'public');
                        AchievementAttachment::create([
                            'achievement_id' => $achievement->id,
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                        ]);
                    }
                }
            }

            DB::commit();

            Alert::success('Berhasil!', 'Prestasi berhasil diperbarui.');
            return redirect()->route('achievement.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update achievement: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal memperbarui prestasi: ' . $e->getMessage());
            return redirect()->route('achievement.index');
        }
    }

    public function destroy($id)
    {
        try {
            $achievement = Achievement::findOrFail($id);
            DB::beginTransaction();

            // Delete associated attachments
            foreach ($achievement->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }

            $achievement->delete();

            DB::commit();

            Alert::success('Berhasil!', 'Prestasi berhasil dihapus.');
            return redirect()->route('achievement.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete achievement: ' . $e->getMessage());
            Alert::error('Gagal!', 'Gagal menghapus prestasi: ' . $e->getMessage());
            return redirect()->route('achievement.index');
        }
    }
}