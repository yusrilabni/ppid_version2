<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OFFICIAL REPORT - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF ULTRA PREMIUM DESIGN - VERSION 4.0 */
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f8fafc; /* Slate 50 */
            margin: 0;
            padding: 0;
            color: #334155;
        }
        .wrapper {
            padding: 20px;
        }
        .document {
            background-color: #ffffff;
            width: 17.5cm;
            margin: 0 auto;
            min-height: 27cm;
            padding: 40px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        /* Official Letterhead */
        .letterhead {
            border-bottom: 8px double #1e3a8a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            max-width: 150px;
            height: auto;
        }
        .header-info {
            text-align: right;
            vertical-align: middle;
        }
        .header-info h1 {
            font-size: 22pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .header-info p {
            font-size: 10pt;
            color: #64748b;
            margin: 4px 0 0 0;
            font-weight: 600;
        }

        /* Hero Summary */
        .hero-summary {
            background-color: #1e3a8a;
            border-radius: 16px;
            padding: 30px;
            color: #ffffff;
            margin-bottom: 35px;
            text-align: center;
        }
        .hero-summary small {
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #93c5fd;
            display: block;
            margin-bottom: 8px;
        }
        .hero-summary h2 {
            font-size: 16pt;
            font-weight: 800;
            margin: 0 0 15px 0;
        }
        .code-tag {
            background-color: #fbbf24; /* Amber 400 */
            color: #1e3a8a;
            font-family: monospace;
            padding: 8px 25px;
            border-radius: 8px;
            font-size: 14pt;
            font-weight: 900;
            display: inline-block;
        }

        /* Modern Section Styling */
        .section {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }
        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .section-title {
            font-size: 11pt;
            font-weight: 900;
            color: #1e3a8a;
            text-transform: uppercase;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 5px;
        }

        /* Professional Data Grid */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            width: 32%;
            text-align: left;
            padding: 12px 15px;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 9pt;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            font-size: 10pt;
            font-weight: 700;
            color: #0f172a;
        }

        /* Premium Content Card */
        .content-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 8px solid #fbbf24;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 0 12px 12px 0;
        }
        .label-pill {
            font-size: 7.5pt;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }
        .content-text {
            font-size: 11pt;
            line-height: 1.6;
            color: #334155;
        }

        /* Timeline Activities */
        .timeline {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }
        .tm-header {
            background-color: #f8fafc;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 800;
            font-size: 10pt;
            color: #1e3a8a;
        }
        .tm-list {
            padding: 20px;
        }
        .tm-item {
            border-left: 4px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 25px;
            position: relative;
        }
        .tm-item::before {
            content: "";
            position: absolute;
            left: -10px;
            top: 0;
            width: 16px;
            height: 16px;
            background-color: #1e3a8a;
            border-radius: 50%;
            border: 4px solid #ffffff;
        }
        .tm-meta {
            font-size: 9pt;
            font-weight: 800;
            margin-bottom: 5px;
        }
        .tm-user { color: #0f172a; text-transform: uppercase; }
        .tm-date { color: #94a3b8; margin-left: 10px; font-weight: 400; }
        .tm-stars { color: #f59e0b; font-family: DejaVu Sans, sans-serif; margin-left: 10px; }
        .tm-msg { font-size: 10pt; color: #475569; }
        .tm-link {
            margin-top: 10px;
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 8.5pt;
            color: #0284c7;
            font-weight: bold;
        }

        /* Footer Signature */
        .footer {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
            page-break-inside: avoid;
        }
        .contact-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            font-size: 8.5pt;
            color: #64748b;
            line-height: 1.4;
            width: 55%;
        }
        .signature-area {
            text-align: center;
            vertical-align: top;
        }
        .sig-name {
            font-size: 12pt;
            font-weight: 900;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-top: 50px;
            border-bottom: 2px solid #1e3a8a;
            display: inline-block;
        }
        .sig-nip {
            font-size: 9pt;
            font-weight: 800;
            color: #0f172a;
            margin-top: 4px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="document">
        <!-- Header -->
        <div class="letterhead">
            <table class="header-table">
                <tr>
                    <td style="width: 150px;">
                        @if(!empty($ppidLogoBase64))
                            <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                        @else
                            <div style="font-weight: 900; color: #1e3a8a; font-size: 24pt;">PPID</div>
                        @endif
                    </td>
                    <td class="header-info">
                        <h1>PPID KABUPATEN SINJAI</h1>
                        <p>Pejabat Pengelola Informasi dan Dokumentasi</p>
                        <p style="font-style: italic; color: #3b82f6;">Mewujudkan Transparansi Informasi Publik</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Hero Card -->
        <div class="hero-summary">
            <small>Laporan Detail Permohonan</small>
            <h2>RINCIAN DATA INFORMASI PUBLIK</h2>
            <div class="code-tag">{{ $permohonan->unique_code }}</div>
            
            <div style="margin-top: 20px;">
                <span style="border: 2px solid #ffffff; padding: 4px 15px; border-radius: 20px; font-size: 8pt; font-weight: 800; text-transform: uppercase;">
                    {{ $permohonan->status_permohonan }}
                </span>
                <span style="background-color: #fbbf24; color: #1e3a8a; padding: 6px 15px; border-radius: 20px; font-size: 8pt; font-weight: 900; text-transform: uppercase; margin-left: 10px;">
                    {{ $permohonan->privacy_status }}
                </span>
            </div>
        </div>

        <!-- Section: Identitas -->
        <div class="section">
            <div class="section-title">I. Identitas Pemohon</div>
            <table class="data-table">
                <tr>
                    <th>Nama Pemohon</th>
                    <td>
                        @if ($permohonan->privacy_status == 'Anonim')
                            <span style="color: #94a3b8;">[DATA DISAMARKAN SISTEM]</span>
                        @else
                            {{ strtoupper($permohonan->nama_pemohon) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Alamat Lengkap</th>
                    <td>{{ $permohonan->alamat_pemohon }}</td>
                </tr>
                <tr>
                    <th>Kontak / Pekerjaan</th>
                    <td>
                        @if ($permohonan->privacy_status == 'Anonim')
                            PRIVASI DILINDUNGI
                        @else
                            {{ $permohonan->email_pemohon ?? '-' }} / {{ $permohonan->pekerjaan ?? '-' }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Section: Konten -->
        <div class="section">
            <div class="section-title">II. Deskripsi Permohonan</div>
            
            <div class="content-card">
                <span class="label-pill">Informasi yang Dibutuhkan:</span>
                <div class="content-text">{!! nl2br(e($permohonan->detail_informasi)) !!}</div>
            </div>

            <div class="content-card" style="border-left-color: #3b82f6;">
                <span class="label-pill">Tujuan Penggunaan Data:</span>
                <div class="content-text">{!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}</div>
            </div>
        </div>

        <!-- Section: Tanggapan -->
        <div class="section">
            <div class="section-title">III. Log Tanggapan & Aktivitas</div>
            <div class="timeline">
                <div class="tm-header">RIWAYAT LAYANAN</div>
                <div class="tm-list">
                    @forelse($permohonan->responses as $response)
                        <div class="tm-item">
                            <div class="tm-meta">
                                <span class="tm-user">{{ $response->user->name ?? 'PEMOHON' }}</span>
                                <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                                
                                @if($response->user_id == $permohonan->user_id && $permohonan->rating)
                                    <span class="tm-stars">@for($i=0;$i<$permohonan->rating;$i++) ★ @endfor</span>
                                @endif
                            </div>
                            <div class="tm-msg">{!! nl2br(e($response->message)) !!}</div>
                            
                            @if($response->file_path)
                                <div class="tm-link">DOKUMEN: {{ asset('storage/' . $response->file_path) }}</div>
                            @endif
                            @if($response->link)
                                <div class="tm-link">LINK: {{ $response->link }}</div>
                            @endif
                        </div>
                    @empty
                        <p style="text-align: center; color: #94a3b8; font-style: italic;">Belum ada tanggapan resmi.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td class="contact-info">
                        <strong style="color: #1e3a8a; font-size: 10pt;">KONTAK LAYANAN PPID:</strong><br>
                        PPID KABUPATEN SINJAI<br>
                        Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                        Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                        <strong>Telp:</strong> 0482-21432 | <strong>Email:</strong> ppidkabsinjai@gmail.com
                    </td>
                    <td class="signature-area">
                        <p style="font-size: 9pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
                        <p style="font-weight: 800; font-size: 10pt; margin-top: 5px;">PETUGAS PPID KAB. SINJAI,</p>
                        
                        @php
                            $adminRes = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                            $adminUser = $adminRes ? $adminRes->user : null;
                        @endphp
                        
                        <div class="sig-name">{{ $adminUser ? $adminUser->name : 'ADMIN PPID' }}</div>
                        @if($adminUser && $adminUser->nip)
                            <div class="sig-nip">NIP. {{ $adminUser->nip }}</div>
                        @endif
                    </td>
                </tr>
            </table>
            
            <div style="margin-top: 30px; text-align: center; border-top: 1px solid #e2e8f0; padding-top: 10px;">
                <p style="font-size: 7pt; color: #cbd5e1; letter-spacing: 2px; font-weight: 800;">
                    OFFICIAL DIGITAL DOCUMENT - PPID KABUPATEN SINJAI
                </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
