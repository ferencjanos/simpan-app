<?php

namespace App\Exports;

use App\Models\SuratKeluar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuratKeluarExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return SuratKeluar::query();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Surat',
            'Tujuan',
            'Perihal',
            'Tanggal Surat',
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
            $row->tujuan,
            $row->perihal,
            $row->tanggal_surat,
            $row->status,
            $row->keterangan,
        ];
    }
}