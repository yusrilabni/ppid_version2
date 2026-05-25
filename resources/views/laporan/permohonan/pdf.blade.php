<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DOC-{{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF PRINT-SAFE OFFICIAL STANDARD - VERSION 4.4 */
        @page {
            size: a4;
            margin: 2.54cm;
        }
        
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10.5pt;
            line-height: 1.6;
            color: #1e293b;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Header / Letterhead */
        .header {
            border-bottom: 3pt double #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 30px;
            width: 100%;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-cell {
            width: 130px;
            vertical-align: middle;
        }
        .logo-img {
            max-width: 120px;
            height: auto;
        }
        .title-cell {
            text-align: right;
            vertical-align: middle;
        }
        .title-cell h1 {
            font-size: 19pt;
            font-weight: 900;
            color: #1e3a8a;
            margin: 0;
            text-transform: uppercase;
        }
        .title-cell p {
            font-size: 9pt;
            color: #64748b;
            margin: 2px 0 0 0;
            font-weight: bold;
        }

        /* Hero Summary */
        .hero-banner {
            background-color: #1e3a8a;
            color: #ffffff;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin-bottom: 35px;
        }
        .hero-banner h2 {
            font-size: 15pt;
            font-weight: 800;
            margin: 0 0 10px 0;
            text-transform: uppercase;
        }
        .code-pill {
            background-color: #fbbf24;
            color: #1e3a8a;
            display: inline-block;
            padding: 5px 20px;
            border-radius: 4px;
            font-size: 13pt;
            font-weight: 900;
            font-family: monospace;
        }

        /* Layout Grid */
        .section {
            margin-bottom: 35px;
            width: 100%;
        }
        .section-title {
            font-size: 11pt;
            font-weight: 900;
            color: #1e3a8a;
            border-bottom: 1.5pt solid #1e3a8a;
            padding-bottom: 3px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        /* Professional Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th {
            width: 32%;
            text-align: left;
            padding: 10px 15px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 9pt;
            color: #475569;
            text-transform: uppercase;
        }
        .data-table td {
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            font-weight: bold;
        }

        /* Description Cards */
        .content-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #fbbf24;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 0 8px 8px 0;
        }
        .content-label {
            font-size: 8pt;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        /* LOG TANGGAPAN */
        .log-page {
            page-break-before: always;
        }
        .timeline-wrapper {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
        }
        .tm-item {
            border-left: 2px solid #cbd5e1;
            padding-left: 20px;
            margin-bottom: 25px;
            position: relative;
            page-break-inside: avoid;
        }
        .tm-item::before {
            content: "";
            position: absolute;
            left: -7px;
            top: 0;
            width: 12px;
            height: 12px;
            background-color: #3b82f6;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }
        .tm-user { font-size: 10pt; font-weight: 800; color: #0f172a; }
        .tm-date { font-size: 8pt; color: #94a3b8; margin-left: 10px; font-weight: 400; }
        
        /* Ikon Bintang Bulletproof (Pakai Border/Teks agar pasti muncul) */
        .tm-stars { 
            margin-left: 10px; 
            color: #f59e0b; 
            font-weight: bold;
            font-size: 12pt;
            letter-spacing: 2px;
        }
        
        .tm-msg { font-size: 10pt; margin-top: 5px; color: #334155; }
        .tm-meta {
            margin-top: 10px;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 8pt;
            color: #1e40af;
            font-weight: bold;
        }

        /* Footer */
        .footer-wrap {
            margin-top: 50px;
            border-top: 1px solid #f1f5f9;
            padding-top: 25px;
            width: 100%;
        }
        .sig-block {
            text-align: center;
            width: 45%;
            float: right;
        }
        .sig-name {
            font-size: 11pt;
            font-weight: 900;
            color: #1e3a8a;
            margin-top: 50px;
            border-bottom: 1.5pt solid #1e3a8a;
            display: inline-block;
            text-transform: uppercase;
        }
        .sig-nip { font-weight: 800; font-size: 9pt; margin-top: 4px; }
        
        .contact-footer {
            font-size: 8.5pt;
            color: #64748b;
            width: 50%;
            float: left;
        }

        .clear { clear: both; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    @if(!empty($ppidLogoBase64))
                        <img src="{{ $ppidLogoBase64 }}" class="logo-img">
                    @else
                        <div style="font-weight: 900; color: #1e3a8a; font-size: 20pt;">PPID</div>
                    @endif
                </td>
                <td class="title-cell">
                    <h1>PPID KABUPATEN SINJAI</h1>
                    <p>Pejabat Pengelola Informasi dan Dokumentasi</p>
                    <p style="font-style: italic; color: #3b82f6;">Transparansi Informasi Publik Pemerintah Kabupaten Sinjai</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Hero Card -->
    <div class="hero-banner">
        <small>Official Service Report</small>
        <h2>RINCIAN PERMOHONAN INFORMASI</h2>
        <div class="code-pill">{{ $permohonan->unique_code }}</div>
        
        <div style="margin-top: 15px;">
            <span style="border: 1px solid #ffffff; padding: 3px 12px; border-radius: 4px; font-size: 8pt; font-weight: 800; text-transform: uppercase;">
                {{ $permohonan->status_permohonan }}
            </span>
            <span style="background-color: #fbbf24; color: #1e3a8a; padding: 4px 12px; border-radius: 4px; font-size: 8pt; font-weight: 900; text-transform: uppercase; margin-left: 10px;">
                {{ $permohonan->privacy_status }}
            </span>
        </div>
    </div>

    <!-- Section I -->
    <div class="section">
        <div class="section-title">I. Identitas Pemohon</div>
        <table class="data-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        <span style="color: #94a3b8;">[DATA DISAMARKAN SISTEM]</span>
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
                <th>Kontak / Pekerjaan</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        DILINDUNGI KEBIJAKAN PRIVASI
                    @else
                        {{ $permohonan->email_pemohon ?? '-' }} / {{ strtoupper($permohonan->pekerjaan ?? '-') }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Section II -->
    <div class="section">
        <div class="section-title">II. Deskripsi Permohonan</div>
        
        <div class="content-box">
            <span class="content-label">Informasi yang Diminta:</span>
            <div class="content-text">{!! nl2br(e($permohonan->detail_informasi)) !!}</div>
        </div>

        <div class="content-box" style="border-left-color: #3b82f6;">
            <span class="content-label">Tujuan Penggunaan:</span>
            <div class="content-text">{!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}</div>
        </div>
    </div>

    <!-- Section III -->
    <div class="section log-page">
        <div class="section-title">III. Log Tanggapan & Aktivitas</div>
        <div class="timeline-wrapper">
            @forelse($permohonan->responses as $response)
                <div class="tm-item">
                    <div class="tm-user">{{ strtoupper($response->user->name ?? 'PEMOHON') }}
                        <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                        
                        {{-- BINTANG - PAKAI LOGIKA GAMBAR/TEKS AMAN --}}
                        @if($response->user_id == $permohonan->user_id && $permohonan->rating)
                            <span class="tm-stars">
                                @for($i=0;$i<$permohonan->rating;$i++)*@endfor
                            </span>
                        @endif
                    </div>
                    <div class="tm-msg">{!! nl2br(e($response->message)) !!}</div>
                    
                    @if($response->file_path)
                        <div class="tm-meta">LAMPIRAN: {{ asset('storage/' . $response->file_path) }}</div>
                    @endif
                    @if($response->link)
                        <div class="tm-meta">LINK: {{ $response->link }}</div>
                    @endif
                </div>
            @empty
                <p style="text-align: center; color: #94a3b8;">Belum ada tanggapan.</p>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-wrap">
        <div class="contact-footer">
            <strong>KONTAK PPID KABUPATEN SINJAI</strong><br>
            Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
            Kabupaten Sinjai, Sulawesi Selatan 92611<br>
            Telp: 0482-21432 | Email: ppidkabsinjai@gmail.com
        </div>

        <div class="sig-block">
            <p style="font-size: 9pt; margin: 0;">Sinjai, {{ date('d F Y') }}</p>
            <p style="font-weight: 800; margin-top: 5px;">Petugas PPID,</p>
            
            @php
                $adminRes = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                $adminUser = $adminRes ? $adminRes->user : null;
            @endphp
            
            <div class="sig-name">{{ $adminUser ? $adminUser->name : 'ADMIN PPID' }}</div>
            @if($adminUser && $adminUser->nip)
                <div class="sig-nip">NIP. {{ $adminUser->nip }}</div>
            @endif
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
