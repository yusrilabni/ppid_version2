<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PDF - {{ $permohonan->unique_code }}</title>
    <style>
        @page {
            margin: 0; /* Kita atur margin di body agar background bisa full jika perlu */
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 1.5cm;
            color: #334155;
            background-color: #ffffff;
            line-height: 1.6;
        }
        /* Header Web Style */
        .web-header {
            border-bottom: 4px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-box {
            width: 150px;
        }
        .logo-img {
            max-width: 140px;
            height: auto;
        }
        .text-right {
            text-align: right;
        }
        .app-name {
            font-size: 18pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
        }
        .app-desc {
            font-size: 9pt;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        /* Title Card */
        .title-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .page-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1e293b;
            margin: 0 0 5px 0;
            text-align: center;
        }
        .unique-code {
            font-family: 'Courier', monospace;
            font-size: 11pt;
            color: #1e3a8a;
            background: #dbeafe;
            padding: 2px 10px;
            border-radius: 4px;
            text-align: center;
            display: block;
            width: fit-content;
            margin: 5px auto;
        }

        /* Grid System for DomPDF (using tables) */
        .section-container {
            margin-bottom: 25px;
        }
        .section-header {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            width: 30%;
            text-align: left;
            padding: 10px;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9pt;
            border: 1px solid #e2e8f0;
        }
        .data-table td {
            padding: 10px;
            color: #1e293b;
            font-size: 10pt;
            border: 1px solid #e2e8f0;
        }

        /* Message Box like Web Card */
        .card-message {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #1e3a8a;
            padding: 15px;
            margin-bottom: 15px;
            font-size: 10pt;
        }
        .label-text {
            font-weight: bold;
            color: #64748b;
            font-size: 8pt;
            margin-bottom: 5px;
            display: block;
        }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .badge-success { background-color: #10b981; }
        .badge-info { background-color: #3b82f6; }
        .badge-warning { background-color: #f59e0b; }

        /* Footer Signature */
        .footer-wrap {
            margin-top: 50px;
        }
        .sig-table {
            width: 100%;
        }
        .sig-text {
            text-align: center;
            font-size: 9pt;
        }
        .sig-space {
            height: 60px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="web-header">
        <table class="header-table">
            <tr>
                <td class="logo-box">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: bold; color: #1e3a8a;">LOGO PPID</div>
                    @endif
                </td>
                <td class="text-right">
                    <p class="app-name">PPID KABUPATEN SINJAI</p>
                    <p class="app-desc">Pejabat Pengelola Informasi dan Dokumentasi</p>
                    <p class="app-desc" style="font-style: italic;">"Terwujudnya Pelayanan Informasi yang Cepat, Tepat, dan Transparan"</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Title Card -->
    <div class="title-card">
        <h1 class="page-title">DETAIL PERMOHONAN INFORMASI PUBLIK</h1>
        <div class="unique-code">{{ $permohonan->unique_code }}</div>
        <div style="text-align: center; margin-top: 10px;">
            <span class="badge badge-success">{{ $permohonan->status_permohonan }}</span>
            <span class="badge badge-info">{{ $permohonan->privacy_status }}</span>
        </div>
    </div>

    <!-- Section: Data Pengajuan -->
    <div class="section-container">
        <div class="section-header">A. Informasi Pengajuan</div>
        <table class="data-table">
            <tr>
                <th>Tanggal Pengajuan</th>
                <td>{{ $permohonan->created_at->translatedFormat('d F Y, H:i') }} WITA</td>
            </tr>
            <tr>
                <th>Rating Kepuasan</th>
                <td>{{ $permohonan->rating ? $permohonan->rating . ' / 5 Bintang' : 'Belum Memberikan Penilaian' }}</td>
            </tr>
        </table>
    </div>

    <!-- Section: Data Pemohon -->
    <div class="section-container">
        <div class="section-header">B. Identitas Pemohon</div>
        <table class="data-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        <span style="color: #94a3b8; font-style: italic;">[Data Disamarkan oleh Sistem]</span>
                    @else
                        {{ $permohonan->nama_pemohon }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Alamat Lengkap</th>
                <td>{{ $permohonan->alamat_pemohon }}</td>
            </tr>
            <tr>
                <th>Kontak & Email</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        <span style="color: #94a3b8; font-style: italic;">***-**** / *****@***</span>
                    @else
                        {{ $permohonan->nomor_telepon_pemohon ?? '-' }} / {{ $permohonan->email_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Pekerjaan</th>
                <td>{{ $permohonan->pekerjaan ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Section: Konten Permohonan -->
    <div class="section-container">
        <div class="section-header">C. Rincian Informasi</div>
        
        <span class="label-text">INFORMASI YANG DIBUTUHKAN:</span>
        <div class="card-message">
            {!! nl2br(e($permohonan->detail_informasi)) !!}
        </div>

        <span class="label-text">TUJUAN PENGGUNAAN INFORMASI:</span>
        <div class="card-message" style="border-left-color: #64748b;">
            {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
        </div>
    </div>

    <!-- Section: Distribusi -->
    <div class="section-container">
        <div class="section-header">D. Metode Perolehan</div>
        @php
            $caraMemperoleh = json_decode($permohonan->cara_memperoleh_informasi, true);
            $caraSalinan = json_decode($permohonan->cara_mendapatkan_salinan, true);
        @endphp
        <table class="data-table">
            <tr>
                <th>Cara Memperoleh</th>
                <td>{{ is_array($caraMemperoleh) ? implode(', ', $caraMemperoleh) : $permohonan->cara_memperoleh_informasi }}</td>
            </tr>
            <tr>
                <th>Format Salinan</th>
                <td>{{ is_array($caraSalinan) ? implode(', ', $caraSalinan) : $permohonan->cara_mendapatkan_salinan }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer Signature -->
    <div class="footer-wrap">
        <table class="sig-table">
            <tr>
                <td style="width: 60%;"></td>
                <td class="sig-text">
                    <p>Sinjai, {{ now()->translatedFormat('d F Y') }}</p>
                    <p style="font-weight: bold;">ADMIN PPID KAB. SINJAI</p>
                    <div class="sig-space"></div>
                    <p class="sig-name">Sistem Layanan PPID</p>
                    <p style="font-size: 7pt; color: #94a3b8;">Dicetak otomatis pada {{ date('H:i:s') }} WITA</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

