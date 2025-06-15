<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spo;

class SPOController extends Controller
{
    // GENERATE SPO
    public function index(Request $request)
    {
        $spo = Spo::with(['student', 'pelanggaran.violation', 'waliKelas', 'wakaSiswa', 'kepalaSekolah'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->get();

        return view('pages.spo.index', compact('spo'));
    }

    public function report(Request $request, $id)
    {
        // Fetch SPO with related data
        $spo = Spo::with(['student', 'pelanggaran.violation', 'waliKelas', 'wakaSiswa', 'kepalaSekolah'])->findOrFail($id);

        return view('pages.spo.report-spo', compact('spo'));
    }

    // View spo detail
    public function viewDetail($id)
    {
        // Ambil data SPO dengan relasinya
        $spo = Spo::with(['student', 'pelanggaran.violation', 'waliKelas', 'wakaSiswa', 'kepalaSekolah'])->findOrFail($id);

        // Return partial view khusus untuk modal detail
        return view('pages.spo.modal-detail', compact('spo'));
    }
}
