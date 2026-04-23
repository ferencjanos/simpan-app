<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Surat Masuk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 11px; text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Surat Masuk</h2>
    <p class="text-center">Tanggal cetak: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Pengirim</th>
                <th>Perihal</th>
                <th>Tanggal Surat</th>
                <th>Tanggal Terima</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suratMasuk as $index => $surat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $surat->nomor_surat }}</td>
                <td>{{ $surat->pengirim }}</td>
                <td>{{ $surat->perihal }}</td>
                <td>{{ $surat->tanggal_surat }}</td>
                <td>{{ $surat->tanggal_terima }}</td>
                <td>{{ ucfirst($surat->status) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>