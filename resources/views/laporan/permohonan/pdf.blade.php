<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Report - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF ULTRA MODERN COMPACT - VERSION 3.2 */
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
            margin: 0.5cm auto;
            background-color: #ffffff;
            min-height: 28cm;
            padding: 1.2cm;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            position: relative;
        }
        
        /* Header Style Compact */
        .header-web {
            border-bottom: 4px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            max-width: 140px;
            height: auto;
        }
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .brand-main {
            font-size: 20pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            letter-spacing: -1px;
        }
        .brand-sub {
            font-size: 8.5pt;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Title Card Compact */
        .title-card {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px 15px;
            text-align: center;
            margin-bottom: 25px;
        }
        .doc-type {
            font-size: 8pt;
            font-weight: 800;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 8px;
        }
        .doc-title {
            font-size: 14pt;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 10px 0;
        }
        .code-box {
            display: inline-block;
            background-color: #1e3a8a;
            color: #ffffff;
            font-family: 'Courier', monospace;
            padding: 5px 20px;
            border-radius: 6px;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Info Grid Compact */
        .info-section {
            margin-bottom: 25px;
        }
        .section-label {
            font-size: 10.5pt;
            font-weight: 800;
            color: #1e3a8a;
            border-left: 5px solid #1e3a8a;
            padding-left: 10px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .data-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }
        .data-grid th {
            width: 32%;
            text-align: left;
            padding: 10px 15px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 8.5pt;
        }
        .data-grid td {
            padding: 10px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9.5pt;
            font-weight: bold;
        }

        /* Content Bubble Compact */
        .bubble-label {
            font-size: 8pt;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 5px;
            display: block;
        }
        .content-bubble {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #3b82f6;
            padding: 15px 20px;
            margin-bottom: 15px;
            font-size: 10pt;
            border-radius: 4px 12px 12px 4px;
            line-height: 1.5;
        }

        /* Timeline Tanggapan */
        .timeline-container {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }
        .tm-item {
            border-left: 2px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 25px;
            position: relative;
            page-break-inside: avoid;
        }
        .tm-dot {
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            background-color: #3b82f6;
            border-radius: 50%;
            border: 3px solid #ffffff;
            box-shadow: 0 0 0 1px #3b82f6;
        }
        .tm-user {
            font-size: 9pt;
            font-weight: 800;
            color: #0f172a;
        }
        .tm-date {
            font-size: 8pt;
            color: #94a3b8;
            margin-left: 6px;
        }
        .tm-stars {
            color: #f59e0b;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            margin-left: 8px;
        }
        .tm-message {
            margin-top: 8px;
            font-size: 10pt;
            color: #334155;
        }
        .tm-link-box {
            margin-top: 10px;
            background-color: #eff6ff;
            border: 1px dashed #3b82f6;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 8.5pt;
            color: #1e40af;
            word-wrap: break-word;
        }

        /* Footer Section */
        .footer-premium {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f1f5f9;
            page-break-inside: avoid;
        }
        .contact-box {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            font-size: 8pt;
            color: #64748b;
        }
        .sig-name {
            font-size: 11pt;
            font-weight: 900;
            color: #1e3a8a;
            margin-top: 50px;
            text-transform: uppercase;
            border-bottom: 2px solid #1e3a8a;
            display: inline-block;
        }
        .sig-nip {
            font-size: 9pt;
            color: #1e293b;
            font-weight: bold;
            margin-top: 2px;
        }
    </style>
</head>
<body>

<div class="main-container">
    <!-- Header Premium -->
    <div class="header-web">
        <table class="header-table">
            <tr>
                <td style="width: 140px;">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: bold; color: #1e3a8a; font-size: 20pt;">PPID</div>
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
        
        <div style="margin-top: 15px;">
            <span style="background-color: #10b981; color: white; padding: 4px 12px; border-radius: 20px; font-size: 7.5pt; font-weight: bold; text-transform: uppercase;">
                {{ $permohonan->status_permohonan }}
            </span>
            <span style="background-color: #3b82f6; color: white; padding: 4px 12px; border-radius: 20px; font-size: 7.5pt; font-weight: bold; text-transform: uppercase; margin-left: 8px;">
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
                <div style="text-align: center; color: #94a3b8; padding: 15px; font-style: italic; font-size: 9pt;">
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
                        <strong style="color: #1e3a8a; font-size: 9pt;">KONTAK LAYANAN:</strong><br>
                        PPID KABUPATEN SINJAI<br>
                        Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                        Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                        <strong>Telp:</strong> 0482-21432 | <strong>Email:</strong> ppidkabsinjai@gmail.com
                    </div>
                </td>
                <td style="text-align: center; vertical-align: top;">
                    <p style="font-size: 9pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
                    <p style="font-weight: 800; font-size: 10pt; margin-top: 5px;">PETUGAS PPID KAB. SINJAI,</p>
                    
                    @php
                        $adminResponse = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                        $adminUser = $adminResponse ? $adminResponse->user : null;
                        $adminDisplayName = $adminUser ? $adminUser->name : 'ADMIN PPID';
                        $adminNip = $adminUser ? $adminUser->nip : null;
                    @endphp
                    
                    <div class="sig-name">{{ strtoupper($adminDisplayName) }}</div>
                    @if($adminNip)
                        <div class="sig-nip">NIP. {{ $adminNip }}</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>
