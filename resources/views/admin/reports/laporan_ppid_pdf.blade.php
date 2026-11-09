<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Layanan Informasi & Keberatan PPID</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            color: #333;
            line-height: 1.4;
            margin: 20px 25px;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px double #2b6cb0;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: middle;
        }
        .logo-img {
            max-height: 75px;
            max-width: 75px;
        }
        .header-title {
            text-align: center;
        }
        .header-title h2 {
            margin: 0;
            font-size: 15pt;
            text-transform: uppercase;
            color: #1a365d;
        }
        .header-title h3 {
            margin: 3px 0;
            font-size: 12pt;
            color: #2b6cb0;
        }
        .header-title p {
            margin: 2px 0 0;
            font-size: 9pt;
            color: #718096;
        }
        .report-meta {
            margin-bottom: 15px;
            font-size: 10pt;
            background: #f7fafc;
            padding: 8px 12px;
            border-left: 4px solid #3182ce;
        }
        .section-title {
            font-size: 12pt;
            font-weight: bold;
            color: #2b6cb0;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #cbd5e0;
            padding-bottom: 4px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9.5pt;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e0;
            padding: 6px 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #ebf8ff;
            color: #2c5282;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8pt;
            border-radius: 3px;
            font-weight: bold;
        }
        .badge-selesai { background-color: #c6f6d5; color: #22543d; }
        .badge-proses { background-color: #feebc8; color: #744210; }
        .badge-pending { background-color: #e2e8f0; color: #4a5568; }
        .badge-ditolak { background-color: #fed7d7; color: #742a2a; }
        .footer-sig {
            margin-top: 30px;
            width: 100%;
        }
        .footer-sig td {
            width: 50%;
            vertical-align: top;
            font-size: 10pt;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            @if(!empty($logo))
            <td width="15%" class="text-center">
                <img src="{{ $logo }}" class="logo-img" alt="Logo">
            </td>
            @endif
            <td width="{{ !empty($logo) ? '85%' : '100%' }}" class="header-title">
                <h2>Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h2>
                <h3>Pemerintah Kabupaten Sinjai</h3>
                <p>Jalan Persatuan Raya No. 1, Sinjai, Sulawesi Selatan | Website: ppid.sinjaikab.go.id</p>
            </td>
        </tr>
    </table>

    <div class="report-meta">
        <strong>REKAPITULASI PELAYANAN INFORMASI & PENANGANAN KEBERATAN TAHUN {{ $year }}</strong><br>
        Periode: {{ $period }} | Waktu Cetak: {{ $generatedAt }} WITA
    </div>

    <!-- Ringkasan Statistik -->
    <div class="section-title">I. Ringkasan Rekapitulasi Pelayanan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="45%">Jenis Layanan Publik</th>
                <th width="12%" class="text-center">Total Masuk</th>
                <th width="12%" class="text-center">Selesai</th>
                <th width="13%" class="text-center">Sedang Proses</th>
                <th width="13%" class="text-center">Ditolak</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td><strong>Permohonan Informasi Publik</strong></td>
                <td class="text-center"><strong>{{ $stats['permohonan_total'] }}</strong></td>
                <td class="text-center">{{ $stats['permohonan_selesai'] }}</td>
                <td class="text-center">{{ $stats['permohonan_proses'] + $stats['permohonan_pending'] }}</td>
                <td class="text-center">{{ $stats['permohonan_ditolak'] }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td><strong>Pengajuan Keberatan Informasi Publik</strong></td>
                <td class="text-center"><strong>{{ $stats['keberatan_total'] }}</strong></td>
                <td class="text-center">{{ $stats['keberatan_selesai'] }}</td>
                <td class="text-center">{{ $stats['keberatan_proses'] + $stats['keberatan_pending'] }}</td>
                <td class="text-center">{{ $stats['keberatan_ditolak'] }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabel Detail Permohonan -->
    <div class="section-title">II. Daftar Registrasi Permohonan Informasi Terkini</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Reg.</th>
                <th width="20%">Nama Pemohon</th>
                <th width="40%">Rincian Informasi Dimohon</th>
                <th width="10%">Tanggal</th>
                <th width="10%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonanList as $idx => $p)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>#{{ $p->unique_code }}</strong></td>
                <td>{{ $p->nama_pemohon }}</td>
                <td>{{ \Illuminate\Support\Str::limit($p->detail_informasi, 80) }}</td>
                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y') }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $p->status_permohonan }}">{{ ucfirst($p->status_permohonan) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="color: #a0aec0;">Belum ada catatan permohonan informasi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tabel Detail Keberatan -->
    <div class="section-title">III. Daftar Pengajuan Keberatan Informasi Terkini</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Tiket</th>
                <th width="15%">No. Reg Asal</th>
                <th width="20%">Nama Pemohon / Kuasa</th>
                <th width="35%">Alasan Keberatan (UU KIP)</th>
                <th width="10%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keberatanList as $idx => $k)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>#{{ $k->unique_code }}</strong></td>
                <td>{{ $k->nomor_pendaftaran_pemohon }}</td>
                <td>{{ $k->nama_pemohon }} @if($k->nama_kuasa)<br><small>(Kuasa: {{ $k->nama_kuasa }})</small>@endif</td>
                <td>{{ \Illuminate\Support\Str::limit($k->alasan_keberatan, 80) }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $k->status_keberatan }}">{{ ucfirst($k->status_keberatan) }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="color: #a0aec0;">Belum ada pengajuan keberatan informasi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <table class="footer-sig">
        <tr>
            <td></td>
            <td class="text-center">
                Sinjai, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}<br>
                <strong>Atasan PPID / PPID Utama<br>Pemerintah Kabupaten Sinjai</strong>
                <br><br><br><br>
                <u>( ___________________________ )</u><br>
                NIP. ....................................................
            </td>
        </tr>
    </table>

</body>
</html>
