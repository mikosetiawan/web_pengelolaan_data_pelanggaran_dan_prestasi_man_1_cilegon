<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('name')->get();
        return view('pages.student.index', compact('students'));
    }

    public function store(Request $request)
    {
        Log::info('Store Student Request:', $request->all());

        $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis',
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:15',
            'father_address' => 'nullable|string',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:15',
            'mother_address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_occupation' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:15',
            'guardian_address' => 'nullable|string',
        ], [
            'nis.required' => 'NISN wajib diisi.',
            'nis.unique' => 'NISN sudah terdaftar.',
            'nis.max' => 'NISN tidak boleh lebih dari 20 karakter.',
            'name.required' => 'Nama siswa wajib diisi.',
            'name.max' => 'Nama siswa tidak boleh lebih dari 255 karakter.',
            'class.required' => 'Kelas wajib diisi.',
            'class.max' => 'Kelas tidak boleh lebih dari 50 karakter.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Aktif atau Tidak Aktif.',
            'phone.max' => 'No. telepon tidak boleh lebih dari 15 karakter.',
            'father_name.max' => 'Nama ayah tidak boleh lebih dari 255 karakter.',
            'father_occupation.max' => 'Pekerjaan ayah tidak boleh lebih dari 100 karakter.',
            'father_phone.max' => 'No. telepon ayah tidak boleh lebih dari 15 karakter.',
            'mother_name.max' => 'Nama ibu tidak boleh lebih dari 255 karakter.',
            'mother_occupation.max' => 'Pekerjaan ibu tidak boleh lebih dari 100 karakter.',
            'mother_phone.max' => 'No. telepon ibu tidak boleh lebih dari 15 karakter.',
            'guardian_name.max' => 'Nama wali tidak boleh lebih dari 255 karakter.',
            'guardian_occupation.max' => 'Pekerjaan wali tidak boleh lebih dari 100 karakter.',
            'guardian_phone.max' => 'No. telepon wali tidak boleh lebih dari 15 karakter.',
        ]);

        try {
            DB::beginTransaction();
            Student::create([
                'nis' => $request->nis,
                'name' => $request->name,
                'class' => $request->class,
                'gender' => $request->gender,
                'status' => $request->status,
                'phone' => $request->phone,
                'address' => $request->address,
                'father_name' => $request->father_name,
                'father_occupation' => $request->father_occupation,
                'father_phone' => $request->father_phone,
                'father_address' => $request->father_address,
                'mother_name' => $request->mother_name,
                'mother_occupation' => $request->mother_occupation,
                'mother_phone' => $request->mother_phone,
                'mother_address' => $request->mother_address,
                'guardian_name' => $request->guardian_name,
                'guardian_occupation' => $request->guardian_occupation,
                'guardian_phone' => $request->guardian_phone,
                'guardian_address' => $request->guardian_address,
            ]);
            DB::commit();

            return redirect()->route('student.index')->with('success', 'Siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store student: ' . $e->getMessage());
            return redirect()->route('student.index')->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        Log::info('Update Student Request for ID: ' . $id, $request->all());

        $request->validate([
            'nis' => 'required|string|max:20|unique:students,nis,' . $id,
            'name' => 'required|string|max:255',
            'class' => 'required|string|max:50',
            'gender' => 'required|in:L,P',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:15',
            'father_address' => 'nullable|string',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:15',
            'mother_address' => 'nullable|string',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_occupation' => 'nullable|string|max:100',
            'guardian_phone' => 'nullable|string|max:15',
            'guardian_address' => 'nullable|string',
        ], [
            'nis.required' => 'NISN wajib diisi.',
            'nis.unique' => 'NISN sudah terdaftar.',
            'nis.max' => 'NISN tidak boleh lebih dari 20 karakter.',
            'name.required' => 'Nama siswa wajib diisi.',
            'name.max' => 'Nama siswa tidak boleh lebih dari 255 karakter.',
            'class.required' => 'Kelas wajib diisi.',
            'class.max' => 'Kelas tidak boleh lebih dari 50 karakter.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status harus Aktif atau Tidak Aktif.',
            'phone.max' => 'No. telepon tidak boleh lebih dari 15 karakter.',
            'father_name.max' => 'Nama ayah tidak boleh lebih dari 255 karakter.',
            'father_occupation.max' => 'Pekerjaan ayah tidak boleh lebih dari 100 karakter.',
            'father_phone.max' => 'No. telepon ayah tidak boleh lebih dari 15 karakter.',
            'mother_name.max' => 'Nama ibu tidak boleh lebih dari 255 karakter.',
            'mother_occupation.max' => 'Pekerjaan ibu tidak boleh lebih dari 100 karakter.',
            'mother_phone.max' => 'No. telepon ibu tidak boleh lebih dari 15 karakter.',
            'guardian_name.max' => 'Nama wali tidak boleh lebih dari 255 karakter.',
            'guardian_occupation.max' => 'Pekerjaan wali tidak boleh lebih dari 100 karakter.',
            'guardian_phone.max' => 'No. telepon wali tidak boleh lebih dari 15 karakter.',
        ]);

        try {
            $student = Student::findOrFail($id);
            DB::beginTransaction();
            $student->update([
                'nis' => $request->nis,
                'name' => $request->name,
                'class' => $request->class,
                'gender' => $request->gender,
                'status' => $request->status,
                'phone' => $request->phone,
                'address' => $request->address,
                'father_name' => $request->father_name,
                'father_occupation' => $request->father_occupation,
                'father_phone' => $request->father_phone,
                'father_address' => $request->father_address,
                'mother_name' => $request->mother_name,
                'mother_occupation' => $request->mother_occupation,
                'mother_phone' => $request->mother_phone,
                'mother_address' => $request->mother_address,
                'guardian_name' => $request->guardian_name,
                'guardian_occupation' => $request->guardian_occupation,
                'guardian_phone' => $request->guardian_phone,
                'guardian_address' => $request->guardian_address,
            ]);
            DB::commit();

            return redirect()->route('student.index')->with('success', 'Siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update student: ' . $e->getMessage());
            return redirect()->route('student.index')->with('error', 'Gagal memperbarui siswa: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);

            if ($student->pelanggarans()->exists()) {
                return response()->json(['error' => 'Siswa tidak dapat dihapus karena memiliki data pelanggaran terkait.']);
            }

            DB::beginTransaction();
            $student->delete();
            DB::commit();

            return response()->json(['success' => 'Siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete student: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus siswa: ' . $e->getMessage()]);
        }
    }
}