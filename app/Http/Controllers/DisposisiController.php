<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DisposisiBaru;

class DisposisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $disposisis = Disposisi::with(['suratMasuk', 'dariUser', 'kepadaUser'])
            ->where('kepada_user_id', Auth::id())
            ->orWhere('dari_user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('disposisi.index', compact('disposisis'));
    }

    public function create(Request $request)
    {
        $suratMasuks = SuratMasuk::all();
        $users = User::where('id', '!=', Auth::id())->get();
        $selectedSurat = $request->surat_masuk_id ? SuratMasuk::find($request->surat_masuk_id) : null;
        return view('disposisi.create', compact('suratMasuks', 'users', 'selectedSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',   // sesuaikan nama tabel jika beda
            'kepada_user_id' => 'required|exists:users,id',
            'instruksi'      => 'required|string',
            'batas_waktu'    => 'nullable|date',
            'catatan'        => 'nullable|string',
        ]);

        $disposisi = Disposisi::create([
            'surat_masuk_id' => $request->surat_masuk_id,
            'dari_user_id'   => Auth::id(),
            'kepada_user_id' => $request->kepada_user_id,
            'instruksi'      => $request->instruksi,
            'batas_waktu'    => $request->batas_waktu,
            'catatan'        => $request->catatan,
            'status'         => 'belum dibaca',
        ]);

        // Kirim notifikasi ke penerima
        $penerima = \App\Models\User::find($request->kepada_user_id);
        if ($penerima) {
            $penerima->notify(new \App\Notifications\DisposisiBaru($disposisi));
        }

        return redirect()->route('disposisi.index')
                        ->with('success', 'Disposisi berhasil dikirim!');
    }

    public function show(Disposisi $disposisi)
    {
        if ($disposisi->kepada_user_id == Auth::id() && $disposisi->status == 'belum dibaca') {
            $disposisi->update(['status' => 'sudah dibaca']);
        }
        return view('disposisi.show', compact('disposisi'));
    }

    public function update(Request $request, Disposisi $disposisi)
    {
        $request->validate([
            'status' => 'required',
            'catatan' => 'nullable',
        ]);

        $disposisi->update([
            'status'  => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('disposisi.index')->with('success', 'Status disposisi berhasil diupdate!');
    }

    public function destroy(Disposisi $disposisi)
    {
        $disposisi->delete();
        return redirect()->route('disposisi.index')->with('success', 'Disposisi berhasil dihapus!');
    }
}