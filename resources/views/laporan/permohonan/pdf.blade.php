<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>OFFICIAL REPORT - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF ULTRA PREMIUM STABILIZED - VERSION 4.1 */
        @page {
            margin: 1.5cm; /* Margin fisik yang sama untuk SEMUA halaman (Halaman 1, 2, dst) */
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #ffffff; /* Putih agar margin @page tidak terlihat belang */
            margin: 0;
            padding: 0;
            color: #334155;
        }

        /* Official Letterhead */
        .letterhead {
            border-bottom: 6px double #1e3a8a;
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
        .header-info {
            text-align: right;
            vertical-align: middle;
        }
        .header-info h1 {
            font-size: 20pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            text-transform: uppercase;
        }
        .header-info p {
            font-size: 9pt;
            color: #64748b;
            margin: 2px 0 0 0;
            font-weight: 600;
        }

        /* Hero Summary */
        .hero-summary {
            background-color: #1e3a8a;
            border-radius: 12px;
            padding: 25px;
            color: #ffffff;
            margin-bottom: 30px;
            text-align: center;
        }
        .hero-summary small {
            font-size: 8pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #93c5fd;
            display: block;
            margin-bottom: 5px;
        }
        .hero-summary h2 {
            font-size: 14pt;
            font-weight: 800;
            margin: 0 0 12px 0;
        }
        .code-tag {
            background-color: #fbbf24;
            color: #1e3a8a;
            font-family: monospace;
            padding: 6px 20px;
            border-radius: 6px;
            font-size: 12pt;
            font-weight: 900;
            display: inline-block;
        }

        /* Section Styling */
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 10.5pt;
            font-weight: 900;
            color: #1e3a8a;
            text-transform: uppercase;
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 4px;
            margin-bottom: 12px;
        }

        /* Data Grid */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            width: 30%;
            text-align: left;
            padding: 10px 12px;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 8.5pt;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            font-size: 9.5pt;
            font-weight: 700;
        }

        /* Content Card */
        .content-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 6px solid #fbbf24;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 0 8px 8px 0;
        }
        .label-pill {
            font-size: 7pt;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }
        .content-text {
            font-size: 10pt;
            line-height: 1.5;
        }

        /* Timeline Activities - PAKSA KE HALAMAN 2 */
        .section-log {
            page-break-before: always; /* MEMAKSA RIWAYAT KE HALAMAN 2 */
            margin-top: 0;
        }
        .timeline {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }
        .tm-item {
            border-left: 3px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 20px;
            position: relative;
            page-break-inside: avoid;
        }
        .tm-item::before {
            content: "";
            position: absolute;
            left: -8px;
            top: 0;
            width: 12px;
            height: 12px;
            background-color: #3b82f6;
            border-radius: 50%;
            border: 3px solid #ffffff;
        }
        .tm-user { font-size: 9.5pt; font-weight: 800; color: #0f172a; }
        .tm-date { font-size: 8pt; color: #94a3b8; margin-left: 8px; }
        .tm-stars { color: #f59e0b; font-family: DejaVu Sans, sans-serif; margin-left: 8px; }
        .tm-msg { font-size: 9.5pt; margin-top: 5px; color: #475569; }
        .tm-link {
            margin-top: 8px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 8pt;
            color: #1e40af;
            font-weight: bold;
        }

        /* Footer Signature */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f1f5f9;
            page-break-inside: avoid;
        }
        .contact-info {
            font-size: 8pt;
            color: #64748b;
            width: 55%;
        }
        .sig-name {
            font-size: 11pt;
            font-weight: 900;
            color: #1e3a8a;
            margin-top: 40px;
            border-bottom: 2px solid #1e3a8a;
            display: inline-block;
            text-transform: uppercase;
        }
        .sig-nip {
            font-size: 9pt;
            font-weight: 800;
            margin-top: 3px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="letterhead">
        <table class="header-table">
            <tr>
                <td style="width: 140px;">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: 900; color: #1e3a8a; font-size: 20pt;">PPID</div>
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
        <small>Laporan Hasil Layanan</small>
        <h2>RINCIAN DATA INFORMASI PUBLIK</h2>
        <div class="code-tag">{{ $permohonan->unique_code }}</div>
        
        <div style="margin-top: 15px;">
            <span style="border: 1px solid #ffffff; padding: 3px 12px; border-radius: 20px; font-size: 7.5pt; font-weight: 800; text-transform: uppercase;">
                {{ $permohonan->status_permohonan }}
            </span>
            <span style="background-color: #fbbf24; color: #1e3a8a; padding: 4px 12px; border-radius: 20px; font-size: 7.5pt; font-weight: 900; text-transform: uppercase; margin-left: 8px;">
                {{ $permohonan->privacy_status }}
            </span>
        </div>
    </div>

    <!-- Section: Identitas -->
    <div class="section">
        <div class="section-title">I. Identitas Pemohon</div>
        <table class="data-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        [DATA DISAMARKAN SISTEM]
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

    <!-- Section: Tanggapan - DIPAKSA KE HALAMAN 2 -->
    <div class="section section-log">
        <div class="section-title">III. Log Tanggapan & Aktivitas</div>
        <div class="timeline">
            @forelse($permohonan->responses as $response)
                <div class="tm-item">
                    <div class="tm-user">{{ $response->user->name ?? 'PEMOHON' }}
                        <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                        @if($response->user_id == $permohonan->user_id && $permohonan->rating)
                            <span class="tm-stars">@for($i=0;$i<$permohonan->rating;$i++) ★ @endfor</span>
                        @endif
                    </div>
                    <div class="tm-msg">{!! nl2br(e($response->message)) !!}</div>
                    
                    @if($response->file_path)
                        <div class="tm-link">LAMPIRAN: {{ asset('storage/' . $response->file_path) }}</div>
                    @endif
                    @if($response->link)
                        <div class="tm-link">LINK: {{ $response->link }}</div>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #94a3b8; font-style: italic;">Belum ada tanggapan.</p>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="contact-info">
                    <strong style="color: #1e3a8a;">PPID KABUPATEN SINJAI</strong><br>
                    Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                    Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                    Telp: 0482-21432 | Email: ppidkabsinjai@gmail.com
                </td>
                <td style="text-align: center; vertical-align: top;">
                    <p style="font-size: 9pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
                    <p style="font-weight: 800; font-size: 10pt; margin-top: 5px;">PETUGAS PPID,</p>
                    
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
    </div>

</body>
</html>
