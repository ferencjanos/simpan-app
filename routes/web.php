<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('surat-masuk/export/excel', [SuratMasukController::class, 'exportExcel'])->name('surat-masuk.export.excel');
Route::get('surat-masuk/export/pdf', [SuratMasukController::class, 'exportPdf'])->name('surat-masuk.export.pdf');
Route::resource('surat-masuk', SuratMasukController::class);

Route::get('surat-keluar/export/excel', [SuratKeluarController::class, 'exportExcel'])->name('surat-keluar.export.excel');
Route::get('surat-keluar/export/pdf', [SuratKeluarController::class, 'exportPdf'])->name('surat-keluar.export.pdf');
Route::resource('surat-keluar', SuratKeluarController::class);
Route::resource('user', UserController::class)->except(['show']);
Route::resource('kategori', KategoriController::class)->except(['show']);
Route::resource('disposisi', DisposisiController::class)->except(['edit']);
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('notifications/readall', [NotificationController::class, 'readAll'])->name('notifications.readall');
Route::get('/logout-get', function() {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.get');
Route::get('activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

