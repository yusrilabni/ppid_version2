<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Report - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF ULTRA MODERN DESIGN - VERSION 3.1 */
        @page {
            margin: 0; 
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f1f5f9; 
            margin: 0;
            padding: 0;
            color: #1e293b;
        }
        .main-container {
            width: 18.5cm;
            margin: 0.8cm auto;
            background-color: #ffffff;
            min-height: 27cm;
            padding: 1.5cm;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            position: relative;
        }
        
        /* Header Style Identik Web */
        .header-web {
            border-bottom: 5px solid #1e3a8a;
            padding-bottom: 25px;
            margin-bottom: 40px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            max-width: 170px;
            height: auto;
        }
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .brand-main {
            font-size: 24pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            letter-spacing: -1.5px;
        }
        .brand-sub {
            font-size: 9.5pt;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 3px;
        }

        /* Title Card Section */
        .title-card {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 35px 20px;
            text-align: center;
            margin-bottom: 35px;
        }
        .doc-type {
            font-size: 9pt;
            font-weight: 800;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 12px;
        }
        .doc-title {
            font-size: 16pt;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 15px 0;
        }
        .code-box {
            display: inline-block;
            background-color: #1e3a8a;
            color: #ffffff;
            font-family: 'Courier', monospace;
            padding: 8px 25px;
            border-radius: 8px;
            font-size: 14pt;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(30, 58, 138, 0.2);
        }

        /* Info Grid */
        .info-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .section-label {
            font-size: 12pt;
            font-weight: 800;
            color: #1e3a8a;
            border-left: 6px solid #1e3a8a;
            padding-left: 12px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .data-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }
        .data-grid th {
            width: 35%;
            text-align: left;
            padding: 15px 20px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 9.5pt;
        }
        .data-grid td {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5pt;
            font-weight: bold;
        }

        /* Content Bubble (Description) */
        .bubble-label {
            font-size: 9pt;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 8px;
            text-transform: uppercase;
            display: block;
        }
        .content-bubble {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #3b82f6;
            padding: 25px;
            margin-bottom: 20px;
            font-size: 11pt;
            border-radius: 4px 16px 16px 4px;
            line-height: 1.7;
            page-break-inside: avoid;
        }

        /* Timeline Tanggapan */
        .timeline-container {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 25px;
        }
        .tm-item {
            border-left: 3px solid #cbd5e1;
            padding-left: 25px;
            margin-bottom: 30px;
            position: relative;
            page-break-inside: avoid;
        }
        .tm-dot {
            position: absolute;
            left: -10px;
            top: 0;
            width: 16px;
            height: 16px;
            background-color: #3b82f6;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 0 0 1px #3b82f6;
        }
        .tm-user {
            font-size: 10pt;
            font-weight: 800;
            color: #0f172a;
        }
        .tm-date {
            font-size: 8.5pt;
            color: #94a3b8;
            margin-left: 8px;
        }
        .tm-stars {
            color: #f59e0b;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            margin-left: 10px;
        }
        .tm-message {
            margin-top: 10px;
            font-size: 11pt;
            color: #334155;
        }
        .tm-link-box {
            margin-top: 15px;
            background-color: #eff6ff;
            border: 1px dashed #3b82f6;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 9pt;
            color: #1e40af;
            word-wrap: break-word;
        }

        /* Footer Section */
        .footer-premium {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 3px solid #f1f5f9;
            page-break-inside: avoid;
        }
        .contact-box {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            font-size: 9pt;
            color: #64748b;
        }
        .sig-name {
            font-size: 12pt;
            font-weight: 900;
            color: #1e3a8a;
            margin-top: 60px;
            text-transform: uppercase;
            display: inline-block;
        }
        .sig-nip {
            font-size: 10pt;
            color: #1e293b;
            font-weight: bold;
            margin-top: 2px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Header Premium -->
    <div class="header-web">
        <table class="header-table">
            <tr>
                <td style="width: 170px;">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: bold; color: #1e3a8a; font-size: 24pt;">PPID</div>
                    @endif
                </td>
                <td class="header-text">
                    <p class="brand-main">PPID KABUPATEN SINJAI</p>
                    <p class="brand-sub">Pejabat Pengelola Informasi dan Dokumentasi</p>
                    <p class="brand-sub" style="font-style: italic; font-weight: 400; text-transform: none;">"Pelayanan Informasi yang Cepat, Tepat, dan Transparan"</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Hero Card -->
    <div class="title-card">
        <div class="doc-type">Laporan Hasil Layanan</div>
        <h1 class="doc-title">RINCIAN PERMOHONAN INFORMASI PUBLIK</h1>
        <div class="code-box">{{ $permohonan->unique_code }}</div>
        
        <div style="margin-top: 20px;">
            <span style="background-color: #10b981; color: white; padding: 5px 15px; border-radius: 20px; font-size: 8pt; font-weight: bold; text-transform: uppercase;">
                {{ $permohonan->status_permohonan }}
            </span>
            <span style="background-color: #3b82f6; color: white; padding: 5px 15px; border-radius: 20px; font-size: 8pt; font-weight: bold; text-transform: uppercase; margin-left: 10px;">
                {{ $permohonan->privacy_status }}
            </span>
        </div>
    </div>

    <!-- Section I: Identitas -->
    <div class="info-section">
        <div class="section-label">I. Identitas Pemohon</div>
        <table class="data-grid">
            <tr>
                <th>NAMA LENGKAP</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        <span style="color: #94a3b8; font-style: italic;">[DATA DISAMARKAN OLEH SISTEM]</span>
                    @else
                        {{ strtoupper($permohonan->nama_pemohon) }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>ALAMAT LENGKAP</th>
                <td>{{ $permohonan->alamat_pemohon }}</td>
            </tr>
            <tr>
                <th>KONTAK RESMI</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        <span style="color: #cbd5e1;">HIDDEN BY PRIVACY POLICY</span>
                    @else
                        {{ $permohonan->email_pemohon ?? '-' }} / {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>PEKERJAAN</th>
                <td>{{ strtoupper($permohonan->pekerjaan ?? 'Tidak Dicantumkan') }}</td>
            </tr>
        </table>
    </div>

    <!-- Section II: Deskripsi -->
    <div class="info-section">
        <div class="section-label">II. Deskripsi Permohonan</div>
        
        <span class="bubble-label">Informasi yang Dibutuhkan:</span>
        <div class="content-bubble">
            {!! nl2br(e($permohonan->detail_informasi)) !!}
        </div>

        <span class="bubble-label">Tujuan Penggunaan Data:</span>
        <div class="content-bubble" style="border-left-color: #64748b; background-color: #ffffff;">
            {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
        </div>
    </div>

    <!-- Section III: Tanggapan -->
    <div class="info-section">
        <div class="section-label">III. Log Aktivitas & Tanggapan</div>
        <div class="timeline-container">
            @forelse($permohonan->responses as $response)
                <div class="tm-item">
                    <div class="tm-dot"></div>
                    <span class="tm-user">{{ strtoupper($response->user->name ?? 'PEMOHON') }}</span>
                    <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                    
                    {{-- Tampilkan Rating jika ini tanggapan pemohon dan ada rating --}}
                    @if($response->user_id == $permohonan->user_id && $permohonan->rating)
                        <span class="tm-stars">
                            @for($i = 0; $i < $permohonan->rating; $i++) &#9733; @endfor
                        </span>
                    @endif

                    <div class="tm-message">
                        {!! nl2br(e($response->message)) !!}
                        
                        {{-- Tampilkan Link/File dengan box khusus agar terlihat --}}
                        @if($response->file_path)
                            <div class="tm-link-box">
                                <strong>LINK LAMPIRAN:</strong><br>
                                {{ asset('storage/' . $response->file_path) }}
                            </div>
                        @endif

                        @if($response->link)
                            <div class="tm-link-box">
                                <strong>LINK TERKAIT:</strong><br>
                                {{ $response->link }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 20px; font-style: italic;">
                    Menunggu tanggapan dari petugas admin PPID Sinjai.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer Signature -->
    <div class="footer-premium">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 55%; vertical-align: top;">
                    <div class="contact-box">
                        <strong style="color: #1e3a8a; font-size: 10pt;">KONTAK LAYANAN:</strong><br>
                        PPID KABUPATEN SINJAI<br>
                        Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                        Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                        <strong>Telp:</strong> 0482-21432 | <strong>Email:</strong> ppidkabsinjai@gmail.com
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top;">
                    <p style="font-size: 10pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
                    <p style="font-weight: 800; font-size: 11pt; margin-top: 5px;">PETUGAS PPID KAB. SINJAI,</p>
                    
                    @php
                        // Logika pengambilan nama Admin (Petugas), bukan pemohon
                        $adminResponse = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                        $adminUser = $adminResponse ? $adminResponse->user : null;
                        
                        $adminDisplayName = $adminUser ? $adminUser->name : 'ADMIN PPID';
                        $adminNip = $adminUser ? $adminUser->nip : null;
                    @endphp
                    
                    <div class="sig-name">{{ strtoupper($adminDisplayName) }}</div>
                    @if($adminNip)
                        <div class="sig-nip">NIP. {{ $adminNip }}</div>
                    @endif
                    
                    <div style="margin-top: 15px; border-top: 1px solid #e2e8f0; padding-top: 5px;">
                        <p style="font-size: 7.5pt; color: #94a3b8; font-weight: 600; letter-spacing: 1px;">
                            OFFICIAL DIGITAL REPORT
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
