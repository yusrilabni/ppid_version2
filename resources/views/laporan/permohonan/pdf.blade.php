<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan - {{ $permohonan->unique_code }}</title>
    <style>
        /* Menggunakan font sistem yang didukung DomPDF */
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #334155;
            background-color: #f8fafc; /* Warna background web */
        }
        .container {
            width: 19cm;
            margin: 1cm auto;
            background-color: #ffffff;
            padding: 1.5cm;
            min-height: 27cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        /* Header Web Style - Persis Web */
        .header-web {
            background-color: #ffffff;
            border-bottom: 5px solid #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
            width: 100%;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            width: 160px; /* Ukuran logo di web */
            height: auto;
        }
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .web-app-name {
            font-size: 20pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
            line-height: 1.1;
        }
        .web-app-sub {
            font-size: 9pt;
            color: #64748b;
            margin-top: 5px;
        }

        /* Title Card - Persis Web */
        .card-title {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            margin-bottom: 30px;
        }
        .main-heading {
            font-size: 16pt;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .code-pill {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            font-family: monospace;
            padding: 4px 16px;
            border-radius: 6px;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Status & Rating Bar */
        .meta-bar {
            width: 100%;
            margin-bottom: 25px;
        }
        .badge {
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .badge-selesai { background-color: #10b981; }
        .badge-publik { background-color: #3b82f6; }
        
        .rating-stars {
            color: #fbbf24;
            font-size: 14pt;
        }

        /* Section Layout - Persis Web */
        .section-box {
            margin-bottom: 30px;
        }
        .section-label {
            font-size: 11pt;
            font-weight: 700;
            color: #1e3a8a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .data-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .data-grid th {
            width: 30%;
            text-align: left;
            padding: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 9pt;
            color: #475569;
        }
        .data-grid td {
            padding: 12px;
            border: 1px solid #e2e8f0;
            font-size: 10pt;
            color: #1e293b;
        }

        /* Message Card - Persis Web */
        .msg-label {
            font-size: 8pt;
            font-weight: bold;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .msg-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #1e3a8a;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 10.5pt;
            border-radius: 4px;
        }

        /* Timeline Tanggapan - Persis Web */
        .timeline-item {
            border-left: 2px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            background-color: #1e3a8a;
            border-radius: 50%;
        }
        .timeline-header {
            font-size: 9pt;
            font-weight: bold;
            color: #334155;
        }
        .timeline-date {
            font-size: 8pt;
            color: #94a3b8;
            margin-left: 8px;
        }
        .timeline-body {
            margin-top: 5px;
            font-size: 10pt;
            color: #475569;
        }

        /* Office Footer - Kontak Lengkap */
        .office-footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }
        .footer-col {
            width: 50%;
            vertical-align: top;
            font-size: 8pt;
            color: #64748b;
        }

        /* Signature Area */
        .sig-box {
            text-align: center;
            padding: 20px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 60px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Web Style -->
    <div class="header-web">
        <table class="header-table">
            <tr>
                <td style="width: 160px;">
                    {{-- Mencoba loading logo via path absolut yang paling mungkin --}}
                    @php
                        $logoLocalPath = public_path('assets/images/logo-ppid.png');
                        if (!file_exists($logoLocalPath)) {
                            $logoLocalPath = storage_path('app/public/logo/Logo PPID With Caption.png');
                        }
                    @endphp
                    @if(file_exists($logoLocalPath))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoLocalPath)) }}" class="logo-img">
                    @else
                        <div style="font-weight: bold; color: #1e3a8a; font-size: 24pt;">PPID</div>
                    @endif
                </td>
                <td class="header-text">
                    <p class="web-app-name">PPID KABUPATEN SINJAI</p>
                    <p class="web-app-sub">Pejabat Pengelola Informasi dan Dokumentasi</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Title Card -->
    <div class="card-title">
        <div class="main-heading">DETAIL PERMOHONAN INFORMASI PUBLIK</div>
        <div class="code-pill">{{ $permohonan->unique_code }}</div>
    </div>

    <!-- Meta Info -->
    <table class="meta-bar">
        <tr>
            <td>
                <span class="badge badge-selesai">{{ $permohonan->status_permohonan }}</span>
                <span class="badge badge-publik">{{ $permohonan->privacy_status }}</span>
            </td>
            <td style="text-align: right;">
                @if($permohonan->rating)
                    <div style="font-size: 8pt; color: #64748b; margin-bottom: 2px;">RATING KEPUASAN</div>
                    <div class="rating-stars">
                        @for($i = 0; $i < $permohonan->rating; $i++)
                            &#9733; {{-- Entitas HTML untuk Bintang Solid --}}
                        @endfor
                        @for($i = 0; $i < (5 - $permohonan->rating); $i++)
                            <span style="color: #e2e8f0;">&#9733;</span>
                        @endfor
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Section A: Pengajuan -->
    <div class="section-box">
        <div class="section-label">A. INFORMASI PENGAJUAN</div>
        <table class="data-grid">
            <tr>
                <th>TANGGAL PENGAJUAN</th>
                <td>{{ $permohonan->created_at->translatedFormat('d F Y, H:i') }} WITA</td>
            </tr>
            <tr>
                <th>NAMA PEMOHON</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        [DATA DISAMARKAN]
                    @else
                        {{ strtoupper($permohonan->nama_pemohon) }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>ALAMAT</th>
                <td>{{ $permohonan->alamat_pemohon }}</td>
            </tr>
            <tr>
                <th>KONTAK</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        ***-**** / *****@***
                    @else
                        {{ $permohonan->nomor_telepon_pemohon ?? '-' }} / {{ $permohonan->email_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Section B: Konten -->
    <div class="section-box">
        <div class="section-label">B. RINCIAN INFORMASI</div>
        
        <div class="msg-label">Informasi yang Dibutuhkan:</div>
        <div class="msg-box">
            {!! nl2br(e($permohonan->detail_informasi)) !!}
        </div>

        <div class="msg-label">Tujuan Penggunaan:</div>
        <div class="msg-box" style="border-left-color: #64748b;">
            {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
        </div>
    </div>

    <!-- Section C: Tanggapan -->
    <div class="section-box">
        <div class="section-label">C. RIWAYAT TANGGAPAN ADMIN</div>
        @forelse($permohonan->responses as $response)
            <div class="timeline-item">
                <div class="timeline-header">
                    {{ strtoupper($response->user->name ?? 'Admin PPID') }}
                    <span class="timeline-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                </div>
                <div class="timeline-body">{!! nl2br(e($response->message)) !!}</div>
            </div>
        @empty
            <div style="text-align: center; color: #94a3b8; font-style: italic; font-size: 9pt;">Belum ada tanggapan.</div>
        @endforelse
    </div>

    <!-- Footer Office & Signature -->
    <table class="office-footer">
        <tr>
            <td class="footer-col">
                <strong>KONTAK KANTOR PPID SINJAI:</strong><br>
                Email: ppidkabsinjai@gmail.com<br>
                Telepon: 0482-21432<br>
                Alamat: Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                Kabupaten Sinjai, Sulawesi Selatan 92611
            </td>
            <td style="width: 50%; text-align: center; vertical-align: bottom;">
                <div class="sig-box">
                    <p style="font-size: 9pt;">Sinjai, {{ date('d F Y') }}</p>
                    <p style="font-weight: bold;">PETUGAS PPID,</p>
                    @php
                        $lastResponse = $permohonan->responses->last();
                        $adminName = ($permohonan->status_permohonan == 'selesai' && $lastResponse) 
                                     ? ($lastResponse->user->name ?? 'Admin PPID') 
                                     : 'Admin PPID';
                    @endphp
                    <p class="sig-name">{{ $adminName }}</p>
                    <p style="font-size: 7pt; color: #94a3b8;">DICETAK DARI SISTEM PPID SINJAI</p>
                </div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>

