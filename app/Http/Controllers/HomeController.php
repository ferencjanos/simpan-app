<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalSuratMasuk        = SuratMasuk::count();
        $totalSuratKeluar       = SuratKeluar::count();
        $suratMasukBelumDiproses = SuratMasuk::where('status', 'belum diproses')->count();
        $suratMasukSelesai      = SuratMasuk::where('status', 'selesai')->count();
        $suratMasukTerbaru      = SuratMasuk::latest()->take(5)->get();
        $suratKeluarTerbaru     = SuratKeluar::latest()->take(5)->get();

        return view('home', compact(
            'totalSuratMasuk',
            'totalSuratKeluar',
            'suratMasukBelumDiproses',
            'suratMasukSelesai',
            'suratMasukTerbaru',
            'suratKeluarTerbaru'
        ));
    }
}