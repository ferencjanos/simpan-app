<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tujuan',
        'perihal',
        'tanggal_surat',
        'file',
        'status',
        'kategori_id',
        'keterangan',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nomor_surat', 'pengirim', 'perihal', 'status'])
            ->setDescriptionForEvent(fn(string $eventName) => "Surat Masuk {$eventName}");
    }
}