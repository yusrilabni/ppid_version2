<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan Informasi - {{ $permohonan->unique_code }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #333;
        }
        /* Header Styling */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-cell {
            width: 80px;
            vertical-align: middle;
        }
        .logo-img {
            width: 70px;
            height: auto;
        }
        .title-cell {
            text-align: center;
            vertical-align: middle;
        }
        .title-main {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            color: #000;
        }
        .title-sub {
            font-size: 10pt;
            margin: 5px 0 0 0;
            color: #444;
        }
        /* Section Styling */
        .section-title {
            background-color: #f2f2f2;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 12pt;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 5px solid #1a237e;
        }
        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .data-table th {
            width: 35%;
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            font-weight: bold;
            color: #555;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        /* Content Block */
        .content-box {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fafafa;
            margin-bottom: 10px;
            min-height: 50px;
        }
        /* Footer / Signature Area */
        .footer-area {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 9pt;
            font-weight: bold;
            color: #fff;
        }
        .bg-success { background-color: #28a745; }
        .bg-info { background-color: #17a2b8; }
        
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td class="logo-cell">
                @if(!empty($ppidLogoBase64))
                    <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                @endif
            </td>
            <td class="title-cell">
                <h1 class="title-main">Pejabat Pengelola Informasi dan Dokumentasi (PPID)</h1>
                <p class="title-sub">Pemerintah Kabupaten Sinjai - Provinsi Sulawesi Selatan</p>
            </td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="margin: 0; font-size: 14pt;">RINCIAN PERMOHONAN INFORMASI PUBLIK</h2>
        <p style="margin: 5px 0; font-family: monospace;">Kode: {{ $permohonan->unique_code }}</p>
    </div>

    <!-- Informasi Status -->
    <table class="data-table">
        <tr>
            <th>Status Permohonan</th>
            <td><span class="badge bg-success">{{ strtoupper($permohonan->status_permohonan) }}</span></td>
        </tr>
        <tr>
            <th>Privasi Data</th>
            <td><span class="badge bg-info">{{ strtoupper($permohonan->privacy_status) }}</span></td>
        </tr>
        <tr>
            <th>Tanggal Pengajuan</th>
            <td>{{ $permohonan->created_at->translatedFormat('d F Y H:i') }} WITA</td>
        </tr>
    </table>

    <!-- Data Pemohon -->
    <div class="section-title">I. IDENTITAS PEMOHON</div>
    <table class="data-table">
        <tr>
            <th>Nama Lengkap</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    {{ substr($permohonan->nama_pemohon, 0, 1) . '*****' }} (Data Disamarkan)
                @else
                    {{ $permohonan->nama_pemohon }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $permohonan->alamat_pemohon }}</td>
        </tr>
        <tr>
            <th>Pekerjaan</th>
            <td>{{ $permohonan->pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kontak (Telp/Email)</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    ***-**** / *****@***
                @else
                    {{ $permohonan->nomor_telepon_pemohon ?? '-' }} / {{ $permohonan->email_pemohon ?? '-' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- Detail Permohonan -->
    <div class="section-title">II. RINCIAN PERMOHONAN</div>
    <div style="font-weight: bold; margin-bottom: 5px;">Informasi yang Diminta:</div>
    <div class="content-box">
        {!! nl2br(e($permohonan->detail_informasi)) !!}
    </div>

    <div style="font-weight: bold; margin: 15px 0 5px 0;">Tujuan Penggunaan Informasi:</div>
    <div class="content-box">
        {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
    </div>

    <!-- Cara Memperoleh -->
    <div class="section-title">III. DISTRIBUSI INFORMASI</div>
    @php
        $caraMemperoleh = json_decode($permohonan->cara_memperoleh_informasi, true);
        $caraSalinan = json_decode($permohonan->cara_mendapatkan_salinan, true);
    @endphp
    <table class="data-table">
        <tr>
            <th>Cara Memperoleh</th>
            <td>{{ is_array($caraMemperoleh) ? implode(', ', $caraMemperoleh) : '-' }}</td>
        </tr>
        <tr>
            <th>Format Salinan</th>
            <td>{{ is_array($caraSalinan) ? implode(', ', $caraSalinan) : '-' }}</td>
        </tr>
    </table>

    <!-- Penutup & Tanda Tangan -->
    <div class="footer-area clearfix">
        <div class="signature-box">
            <p>Sinjai, {{ date('d F Y') }}</p>
            <p style="margin-top: 60px; font-weight: bold; text-decoration: underline;">Admin PPID Kabupaten Sinjai</p>
            <p style="font-size: 9pt; color: #777;">Dicetak secara otomatis melalui Sistem PPID</p>
        </div>
    </div>

</body>
</html>

