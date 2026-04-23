<?php

namespace App\Exports;

use App\Models\SuratMasuk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratMasukExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return SuratMasuk::query();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Pengirim',
            'Perihal',
            'Tanggal Surat',
            'Tanggal Terima',
            'Status',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nomor_surat,
            $row->pengirim,
            $row->perihal,
            $row->tanggal_surat,
            $row->tanggal_terima,
            $row->status,
            $row->keterangan,
        ];
    }
}