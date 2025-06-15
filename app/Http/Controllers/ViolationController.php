<?php

namespace App\Http\Controllers;

use App\Models\Violation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ViolationController extends Controller
{
    public function index()
    {
        $violations = Violation::orderBy('kategori')->orderBy('nama_pelanggaran')->get();
        return view('pages.violations.index', compact('violations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'skor' => 'required|integer|min:5|max:100',
            'kategori' => 'required|in:ringan,sedang,berat',
        ]);

        try {
            DB::beginTransaction();
            Violation::create([
                'nama_pelanggaran' => $request->nama_pelanggaran,
                'skor' => $request->skor,
                'kategori' => $request->kategori,
            ]);
            DB::commit();

            return redirect()->route('violations.index')
                ->with('success', 'Pelanggaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store violation: ' . $e->getMessage());
            return redirect()->route('violations.index')
                ->with('error', 'Gagal menambahkan pelanggaran: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'skor' => 'required|integer|min:5|max:100',
            'kategori' => 'required|in:ringan,sedang,berat',
        ]);

        $violation = Violation::findOrFail($id);

        try {
            DB::beginTransaction();
            $violation->update([
                'nama_pelanggaran' => $request->nama_pelanggaran,
                'skor' => $request->skor,
                'kategori' => $request->kategori,
            ]);
            DB::commit();

            return redirect()->route('violations.index')
                ->with('success', 'Pelanggaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update violation: ' . $e->getMessage());
            return redirect()->route('violations.index')
                ->with('error', 'Gagal memperbarui pelanggaran: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $violation = Violation::findOrFail($id);
            DB::beginTransaction();
            $violation->delete();
            DB::commit();

            return response()->json(['success' => 'Pelanggaran berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete violation: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus pelanggaran: ' . $e->getMessage()], 500);
        }
    }
}