<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\SuratKeluarExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;

class SuratKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = SuratKeluar::with('kategori');

    if ($request->search) {
        $query->where('nomor_surat', 'like', '%' . $request->search . '%')
              ->orWhere('tujuan', 'like', '%' . $request->search . '%')
              ->orWhere('perihal', 'like', '%' . $request->search . '%');
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $suratKeluar = $query->latest()->paginate(10);
    return view('surat-keluar.index', compact('suratKeluar'));
}

    public function create()
    {
    $kategoris = Kategori::all();
    return view('surat-keluar.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'    => 'required',
            'tujuan'         => 'required',  // ← harus ada
            'perihal'        => 'required',
            'tanggal_surat'  => 'required|date',
            'status'         => 'required',
            'kategori_id'    => 'required',
            'keterangan'     => 'nullable',
            'file'           => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('surat-keluar', 'public');
        }

        $suratKeluar = SuratKeluar::create($data);
        // ✅ Tambahkan log aktivitas di sini
        activity()
            ->causedBy(auth()->user())
            ->performedOn($suratKeluar)
            ->withProperties([
                'nomor_surat' => $suratKeluar->nomor_surat,
                'tujuan'      => $suratKeluar->tujuan,
                'perihal'     => $suratKeluar->perihal,
                'status'      => $suratKeluar->status,
            ])
            ->log('Membuat surat keluar baru');

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil ditambahkan!');
    }

    public function show(SuratKeluar $suratKeluar)
    {
        return view('surat-keluar.show', compact('suratKeluar'));
    }

    public function edit(SuratKeluar $suratKeluar)
    {
    $kategoris = Kategori::all();
    return view('surat-keluar.edit', compact('suratKeluar', 'kategoris'));
    }

    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        $request->validate([
            'nomor_surat'   => 'required',
            'tujuan'        => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status'        => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            if ($suratKeluar->file) {
                Storage::disk('public')->delete($suratKeluar->file);
            }
            $data['file'] = $request->file('file')->store('surat-keluar', 'public');
        }

        // Catat data lama sebelum update
        $dataLama = $suratKeluar->only(['nomor_surat', 'tujuan', 'perihal', 'status']);

        $suratKeluar->update($data);

        // Log manual
        activity()
            ->causedBy(auth()->user())
            ->performedOn($suratKeluar)
            ->withProperties([
                'old'        => $dataLama,
                'attributes' => $suratKeluar->only(['nomor_surat', 'tujuan', 'perihal', 'status']),
            ])
            ->log('Surat Keluar updated');

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil diupdate!');
    }

    public function destroy(SuratKeluar $suratKeluar)
    {
        if ($suratKeluar->file) {
            Storage::disk('public')->delete($suratKeluar->file);
        }
        $suratKeluar->delete();
        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dihapus!');
    }
    public function exportExcel()
    {
        return Excel::download(new SuratKeluarExport, 'surat-keluar.xlsx');
    }

    public function exportPdf()
    {
        $suratKeluar = SuratKeluar::all();
        $pdf = Pdf::loadView('pdf.surat-keluar', compact('suratKeluar'));
        return $pdf->download('surat-keluar.pdf');
    }
}