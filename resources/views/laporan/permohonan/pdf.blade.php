<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PDF - {{ $permohonan->unique_code }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
            background-color: #f1f5f9; /* Background web Sinjai */
        }
        .paper {
            width: 18cm;
            margin: 0.5cm auto;
            background-color: #ffffff;
            padding: 1cm;
            min-height: 27cm;
            border: 1px solid #e2e8f0;
        }
        
        /* Header Web Style */
        .header-web {
            border-bottom: 5px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
        }
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .web-title {
            font-size: 18pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
        }
        .web-subtitle {
            font-size: 9pt;
            color: #64748b;
            margin-top: 2px;
        }

        /* Title Card */
        .card-title {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
            background-color: #ffffff;
        }
        .main-heading {
            font-size: 14pt;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .code-pill {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            padding: 3px 12px;
            border-radius: 5px;
            font-size: 11pt;
            font-weight: bold;
        }

        /* Status & Rating Bar */
        .meta-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .badge-success { background-color: #10b981; }
        .badge-info { background-color: #3b82f6; }
        
        .rating-text {
            color: #f59e0b;
            font-weight: bold;
            font-size: 12pt;
        }

        /* Section Layout */
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            width: 35%;
            text-align: left;
            padding: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 9pt;
            color: #64748b;
        }
        .data-table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 10pt;
            color: #1e293b;
            vertical-align: top;
        }

        /* Content Boxes */
        .msg-label {
            font-weight: bold;
            font-size: 8pt;
            color: #94a3b8;
            margin-top: 15px;
            display: block;
        }
        .msg-box {
            border-left: 5px solid #1e3a8a;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #1e3a8a;
            padding: 12px;
            margin-top: 5px;
            font-size: 10pt;
            border-radius: 4px;
        }

        /* Timeline Tanggapan */
        .response-container {
            margin-top: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 15px;
        }
        .response-item {
            border-left: 2px solid #cbd5e1;
            padding-left: 15px;
            margin-bottom: 15px;
        }
        .response-user {
            font-weight: bold;
            font-size: 9pt;
            color: #334155;
        }
        .response-date {
            font-size: 8pt;
            color: #94a3b8;
            margin-left: 5px;
        }
        .response-body {
            margin-top: 4px;
            font-size: 9.5pt;
        }

        /* Footer & Signature */
        .footer-table {
            width: 100%;
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        .contact-info {
            font-size: 8pt;
            color: #64748b;
            width: 60%;
        }
        .sig-cell {
            text-align: center;
            vertical-align: top;
        }
        .sig-space { height: 60px; }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="paper">
    <!-- Header Web Style -->
    <div class="header-web">
        <table class="header-table">
            <tr>
                <td style="width: 150px;">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: bold; color: #1e3a8a; font-size: 20pt;">PPID</div>
                    @endif
                </td>
                <td class="header-text">
                    <p class="web-title">PPID KABUPATEN SINJAI</p>
                    <p class="web-subtitle">Pejabat Pengelola Informasi dan Dokumentasi</p>
                    <p class="web-subtitle" style="font-style: italic;">"Transparansi Informasi Publik"</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Title Card -->
    <div class="card-title">
        <div class="main-heading">DETAIL PERMOHONAN INFORMASI PUBLIK</div>
        <div class="code-pill">{{ $permohonan->unique_code }}</div>
    </div>

    <!-- Meta Status & Rating -->
    <table class="meta-table">
        <tr>
            <td>
                <span class="badge badge-success">{{ $permohonan->status_permohonan }}</span>
                <span class="badge badge-info">{{ $permohonan->privacy_status }}</span>
            </td>
            <td style="text-align: right;">
                @if($permohonan->rating)
                    <span style="font-size: 8pt; color: #64748b; margin-right: 5px;">KEPUASAN:</span>
                    <span class="rating-text">
                        @for($i = 0; $i < $permohonan->rating; $i++) ★ @endfor
                    </span>
                @endif
            </td>
        </tr>
    </table>

    <!-- Section: Identitas -->
    <div class="section-title">A. IDENTITAS PEMOHON</div>
    <table class="data-table">
        <tr>
            <th>Nama Lengkap</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    <span style="color: #94a3b8; font-style: italic;">[Data Disamarkan]</span>
                @else
                    {{ strtoupper($permohonan->nama_pemohon) }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $permohonan->alamat_pemohon }}</td>
        </tr>
        <tr>
            <th>Kontak (Email/Telp)</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    ***-**** / *****@***
                @else
                    {{ $permohonan->email_pemohon ?? '-' }} / {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- Section: Konten -->
    <div class="section-title">B. RINCIAN PERMOHONAN</div>
    <span class="msg-label">INFORMASI YANG DIBUTUHKAN:</span>
    <div class="msg-box">
        {!! nl2br(e($permohonan->detail_informasi)) !!}
    </div>

    <span class="msg-label">TUJUAN PENGGUNAAN:</span>
    <div class="msg-box" style="border-left-color: #64748b;">
        {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
    </div>

    <!-- Section: Tanggapan -->
    <div class="section-title">C. RIWAYAT TANGGAPAN ADMIN</div>
    <div class="response-container">
        @forelse($permohonan->responses as $response)
            <div class="response-item">
                <div class="response-user">
                    {{ strtoupper($response->user->name ?? 'Admin PPID') }}
                    <span class="response-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                </div>
                <div class="response-body">{!! nl2br(e($response->message)) !!}</div>
            </div>
        @empty
            <div style="text-align: center; color: #94a3b8; font-style: italic; font-size: 9pt;">Belum ada tanggapan resmi.</div>
        @endforelse
    </div>

    <!-- Footer Office & Signature -->
    <table class="footer-table">
        <tr>
            <td class="contact-info">
                <strong>KONTAK KANTOR PPID SINJAI:</strong><br>
                Email: ppidkabsinjai@gmail.com<br>
                Telepon: 0482-21432<br>
                Alamat: Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                Kab. Sinjai, Sulawesi Selatan 92611
            </td>
            <td class="sig-cell">
                <p style="font-size: 9pt;">Sinjai, {{ date('d F Y') }}</p>
                <p style="font-weight: bold;">Petugas PPID,</p>
                <div class="sig-space"></div>
                @php
                    $lastResponse = $permohonan->responses->last();
                    $adminName = ($permohonan->status_permohonan == 'selesai' && $lastResponse) 
                                 ? ($lastResponse->user->name ?? 'Admin PPID') 
                                 : 'Admin PPID';
                @endphp
                <p class="sig-name">{{ $adminName }}</p>
                <p style="font-size: 7pt; color: #94a3b8;">Dicetak otomatis melalui Sistem PPID Sinjai (v2.1)</p>
            </td>
        </tr>
    </table>
</div>

</body>
</html>

