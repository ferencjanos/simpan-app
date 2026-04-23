<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\SuratMasukExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kategori;

class SuratMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = SuratMasuk::with('kategori');

    if ($request->search) {
        $query->where('nomor_surat', 'like', '%' . $request->search . '%')
              ->orWhere('pengirim', 'like', '%' . $request->search . '%')
              ->orWhere('perihal', 'like', '%' . $request->search . '%');
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $suratMasuk = $query->latest()->paginate(10);
    return view('surat-masuk.index', compact('suratMasuk'));
}

    public function create()
    {
    $kategoris = Kategori::all();
    return view('surat-masuk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'   => 'required',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima'=> 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status'        => 'required',
            'kategori_id'   => 'nullable',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('surat-masuk', 'public');
        }

        SuratMasuk::create($data);
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan!');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
    $kategoris = Kategori::all();
    return view('surat-masuk.edit', compact('suratMasuk', 'kategoris'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $request->validate([
            'nomor_surat'   => 'required',
            'pengirim'      => 'required',
            'perihal'       => 'required',
            'tanggal_surat' => 'required|date',
            'tanggal_terima'=> 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status'        => 'required',
        ]);

        $data = $request->all();

        if ($request->hasFile('file')) {
            if ($suratMasuk->file) {
                Storage::disk('public')->delete($suratMasuk->file);
            }
            $data['file'] = $request->file('file')->store('surat-masuk', 'public');
        }

        // Catat data lama sebelum update
        $dataLama = $suratMasuk->only(['nomor_surat', 'pengirim', 'perihal', 'status']);

        $suratMasuk->update($data);

        // Log manual
        activity()
            ->causedBy(auth()->user())
            ->performedOn($suratMasuk)
            ->withProperties([
                'old'        => $dataLama,
                'attributes' => $suratMasuk->only(['nomor_surat', 'pengirim', 'perihal', 'status']),
            ])
            ->log('Surat Masuk updated');

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diupdate!');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file) {
            Storage::disk('public')->delete($suratMasuk->file);
        }
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus!');
    }
    public function exportExcel()
    {
        return Excel::download(new SuratMasukExport, 'surat-masuk.xlsx');
    }

    public function exportPdf()
    {
        $suratMasuk = SuratMasuk::all();
        $pdf = Pdf::loadView('pdf.surat-masuk', compact('suratMasuk'));
        return $pdf->download('surat-masuk.pdf');
    }
}