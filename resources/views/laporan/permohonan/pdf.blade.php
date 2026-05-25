<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF-COMPATIBLE "TAILWIND" STYLES */
        @page {
            margin: 0;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #f1f5f9; /* Slate 100 - Ala Tailwind */
        }
        .paper-container {
            width: 19cm;
            margin: 0 auto;
            padding: 1cm;
        }
        .paper {
            background-color: #ffffff;
            min-height: 27cm;
            padding: 1.5cm;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); /* Shadow ala Tailwind */
            border-radius: 12px;
        }
        
        /* Premium Header */
        .header-premium {
            border-bottom: 6px solid #1e3a8a; /* Blue 900 */
            padding-bottom: 25px;
            margin-bottom: 35px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-img {
            max-width: 160px;
            height: auto;
        }
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 22pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            letter-spacing: -1px;
        }
        .brand-sub {
            font-size: 10pt;
            font-weight: 600;
            color: #64748b; /* Slate 500 */
            margin-top: 4px;
            text-transform: uppercase;
        }

        /* Hero Title Card */
        .hero-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
            background-image: linear-gradient(to bottom right, #ffffff, #f8fafc);
        }
        .doc-label {
            font-size: 9pt;
            font-weight: 800;
            color: #3b82f6; /* Blue 500 */
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .main-title {
            font-size: 16pt;
            font-weight: 800;
            color: #0f172a; /* Slate 900 */
            margin: 0 0 15px 0;
            line-height: 1.2;
        }
        .unique-pill {
            display: inline-block;
            background-color: #1e3a8a;
            color: #ffffff;
            font-family: 'Courier', monospace;
            padding: 6px 20px;
            border-radius: 8px;
            font-size: 13pt;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(30, 58, 138, 0.3);
        }

        /* Status Badges */
        .status-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 8.5pt;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
        }
        .bg-success { background-color: #10b981; } /* Emerald 500 */
        .bg-blue { background-color: #3b82f6; } /* Blue 500 */
        
        .stars-container {
            color: #f59e0b; /* Amber 500 */
            font-size: 16pt;
            font-family: DejaVu Sans, sans-serif;
        }

        /* Sectioning Ala Tailwind */
        .section-wrap {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }
        .section-head {
            font-size: 11pt;
            font-weight: 800;
            color: #1e3a8a;
            border-left: 6px solid #1e3a8a;
            padding-left: 12px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Data Grid */
        .grid-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            page-break-inside: avoid;
        }
        .grid-table th {
            width: 35%;
            text-align: left;
            padding: 14px 18px;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 9pt;
            font-weight: 700;
            color: #64748b;
        }
        .grid-table td {
            padding: 14px 18px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5pt;
            font-weight: 600;
            color: #1e293b;
        }

        /* Content Bubble */
        .content-label {
            font-size: 8.5pt;
            font-weight: 800;
            color: #94a3b8; /* Slate 400 */
            margin-bottom: 8px;
            text-transform: uppercase;
            display: block;
        }
        .content-bubble {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #3b82f6;
            padding: 20px;
            margin-bottom: 20px;
            font-size: 11pt;
            border-radius: 0 12px 12px 0;
            line-height: 1.6;
            page-break-inside: avoid;
        }

        /* Timeline Box */
        .timeline-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            page-break-inside: avoid;
        }
        .tm-item {
            border-left: 3px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 25px;
            position: relative;
        }
        .tm-dot {
            position: absolute;
            left: -8px;
            top: 0;
            width: 12px;
            height: 12px;
            background-color: #3b82f6;
            border-radius: 50%;
            border: 3px solid #ffffff;
        }
        .tm-user {
            font-size: 9.5pt;
            font-weight: 800;
            color: #0f172a;
        }
        .tm-date {
            font-size: 8pt;
            font-weight: 600;
            color: #94a3b8;
            margin-left: 6px;
        }
        .tm-body {
            margin-top: 8px;
            font-size: 10.5pt;
            color: #475569;
        }

        /* Modern Footer */
        .footer-premium {
            margin-top: 60px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }
        .contact-card {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            font-size: 8.5pt;
            color: #64748b;
            line-height: 1.5;
        }
        .sig-name {
            font-size: 12pt;
            font-weight: 900;
            color: #1e3a8a;
            margin-top: 60px;
            text-transform: uppercase;
            border-bottom: 2px solid #1e3a8a;
            display: inline-block;
        }
    </style>
</head>
<body>

<div class="paper-container">
    <div class="paper">
        <!-- Premium Header -->
        <div class="header-premium">
            <table class="header-table">
                <tr>
                    <td style="width: 160px;">
                        @if(!empty($ppidLogoBase64))
                            <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                        @else
                            <div style="font-weight: bold; color: #1e3a8a; font-size: 24pt;">PPID</div>
                        @endif
                    </td>
                    <td class="header-text">
                        <p class="brand-name">PPID SINJAI</p>
                        <p class="brand-sub">Pejabat Pengelola Informasi dan Dokumentasi</p>
                        <p class="brand-sub" style="font-style: italic; font-weight: 400;">Transparansi Pelayanan Publik</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Hero Card -->
        <div class="hero-card">
            <div class="doc-label">Official Report</div>
            <h1 class="main-title">DETAIL PERMOHONAN INFORMASI PUBLIK</h1>
            <div class="unique-pill">{{ $permohonan->unique_code }}</div>
        </div>

        <!-- Status & Rating Bar -->
        <table class="status-table">
            <tr>
                <td>
                    <span class="badge bg-success">{{ $permohonan->status_permohonan }}</span>
                    <span class="badge bg-blue" style="margin-left: 5px;">{{ $permohonan->privacy_status }}</span>
                </td>
                <td style="text-align: right;">
                    @if($permohonan->rating)
                        <div style="font-size: 7.5pt; font-weight: 800; color: #94a3b8; margin-bottom: 4px;">CUSTOMER SATISFACTION</div>
                        <div class="stars-container">
                            @for($i = 0; $i < $permohonan->rating; $i++) &#9733; @endfor
                            <span style="color: #e2e8f0;">@for($i = 0; $i < (5 - $permohonan->rating); $i++) &#9733; @endfor</span>
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Section: Identitas -->
        <div class="section-wrap">
            <div class="section-head">I. Identitas Pemohon</div>
            <table class="grid-table">
                <tr>
                    <th>NAMA LENGKAP</th>
                    <td>
                        @if ($permohonan->privacy_status == 'Anonim')
                            <span style="color: #94a3b8;">[DATA DISAMARKAN SISTEM]</span>
                        @else
                            {{ strtoupper($permohonan->nama_pemohon) }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>ALAMAT DOMISILI</th>
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
                    <td>{{ strtoupper($permohonan->pekerjaan ?? 'TIDAK DICANTUMKAN') }}</td>
                </tr>
            </table>
        </div>

        <!-- Section: Konten -->
        <div class="section-wrap">
            <div class="section-head">II. Deskripsi Permohonan</div>
            
            <span class="content-label">Informasi yang Dibutuhkan:</span>
            <div class="content-bubble">
                {!! nl2br(e($permohonan->detail_informasi)) !!}
            </div>

            <span class="content-label">Tujuan Penggunaan Data:</span>
            <div class="content-bubble" style="border-left-color: #64748b; background-color: #ffffff;">
                {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
            </div>
        </div>

        <!-- Section: Tanggapan -->
        <div class="section-wrap">
            <div class="section-head">III. Log Tanggapan Admin</div>
            <div class="timeline-box">
                @forelse($permohonan->responses as $response)
                    <div class="tm-item">
                        <div class="tm-dot"></div>
                        <span class="tm-user">{{ strtoupper($response->user->name ?? 'PETUGAS PPID') }}</span>
                        <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                        <div class="tm-body">{!! nl2br(e($response->message)) !!}</div>
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; font-style: italic; padding: 20px;">
                        Menunggu tanggapan dari petugas admin PPID.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Footer & Signature -->
        <div class="footer-premium">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="width: 55%; vertical-align: top;">
                        <div class="contact-card">
                            <strong style="color: #1e3a8a; font-size: 9pt;">KONTAK KANTOR PUSAT:</strong><br>
                            Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                            Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                            <strong>Telp:</strong> 0482-21432 | <strong>Email:</strong> ppidkabsinjai@gmail.com
                        </div>
                    </td>
                    <td style="text-align: center; vertical-align: top;">
                        <p style="font-size: 9pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
                        <p style="font-weight: 800; font-size: 10pt; margin-top: 5px;">PETUGAS PPID SINJAI,</p>
                        
                        @php
                            // LOGIKA ANTI-SALAH NAMA: Ambil admin asli, bukan pemohon
                            $adminResponse = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                            $adminDisplayName = ($permohonan->status_permohonan == 'selesai' && $adminResponse) 
                                         ? ($adminResponse->user->name ?? 'ADMIN PPID') 
                                         : 'ADMIN PPID';
                        @endphp
                        
                        <div class="sig-name">{{ $adminDisplayName }}</div>
                        <p style="font-size: 7.5pt; color: #94a3b8; margin-top: 10px; font-weight: 600;">
                            VERIFIED BY PPID SYSTEM v2.3
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

</body>
</html>
