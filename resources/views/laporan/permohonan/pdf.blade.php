<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - {{ $permohonan->unique_code }}</title>
    <style>
        /* DOMPDF STABILIZATION - VERSION 2.5 */
        @page {
            margin: 1.5cm; /* Margin fisik kertas di semua halaman */
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #ffffff; /* Putih bersih agar tidak ada masalah warna di margin */
            line-height: 1.5;
        }
        
        /* Premium Header */
        .header-premium {
            border-bottom: 5px solid #1e3a8a;
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
        .header-text {
            text-align: right;
            vertical-align: middle;
        }
        .brand-name {
            font-size: 20pt;
            font-weight: bold;
            color: #1e3a8a;
            margin: 0;
        }
        .brand-sub {
            font-size: 9pt;
            color: #64748b;
            margin-top: 2px;
        }

        /* Hero Title Card */
        .hero-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
            background-color: #f8fafc;
        }
        .main-title {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 10px 0;
        }
        .unique-pill {
            display: inline-block;
            background-color: #1e3a8a;
            color: #ffffff;
            padding: 4px 15px;
            border-radius: 6px;
            font-size: 12pt;
            font-weight: bold;
        }

        /* Status & Satisfaction Bar */
        .status-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .bg-success { background-color: #10b981; }
        .bg-blue { background-color: #3b82f6; }
        
        .stars {
            color: #f59e0b;
            font-size: 14pt;
            font-family: DejaVu Sans, sans-serif;
        }

        /* Sections */
        .section-wrap {
            margin-bottom: 30px;
            page-break-inside: avoid; /* Mencegah terpotong di tengah */
        }
        .section-head {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            border-left: 5px solid #1e3a8a;
            padding-left: 10px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        /* Data Grid */
        .grid-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e2e8f0;
        }
        .grid-table th {
            width: 30%;
            text-align: left;
            padding: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 9pt;
            color: #64748b;
        }
        .grid-table td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 10pt;
            font-weight: bold;
        }

        /* Content Bubble */
        .content-label {
            font-size: 8pt;
            font-weight: bold;
            color: #94a3b8;
            margin-bottom: 5px;
            display: block;
        }
        .content-bubble {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #3b82f6;
            padding: 15px;
            margin-bottom: 15px;
            font-size: 10.5pt;
            border-radius: 4px;
        }

        /* Timeline Box */
        .timeline-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        .tm-item {
            border-left: 2px solid #cbd5e1;
            padding-left: 15px;
            margin-bottom: 20px;
            position: relative;
            page-break-inside: avoid;
        }
        .tm-dot {
            position: absolute;
            left: -6px;
            top: 0;
            width: 10px;
            height: 10px;
            background-color: #3b82f6;
            border-radius: 50%;
        }
        .tm-user {
            font-size: 9.5pt;
            font-weight: bold;
            color: #0f172a;
        }
        .tm-date {
            font-size: 8pt;
            color: #94a3b8;
            margin-left: 5px;
        }
        .tm-body {
            margin-top: 5px;
            font-size: 10pt;
        }
        .tm-meta-info {
            margin-top: 8px;
            font-size: 8.5pt;
            background: #f1f5f9;
            padding: 5px 10px;
            border-radius: 4px;
            color: #1e40af;
        }

        /* Footer */
        .footer-area {
            margin-top: 50px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
        .sig-name {
            font-size: 12pt;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 50px;
            text-transform: uppercase;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Premium Header -->
    <div class="header-premium">
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
                    <p class="brand-name">PPID KAB. SINJAI</p>
                    <p class="brand-sub">Pejabat Pengelola Informasi dan Dokumentasi</p>
                    <p class="brand-sub" style="font-style: italic;">Transparansi Pelayanan Publik</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Hero Card -->
    <div class="hero-card">
        <h1 class="main-title">DETAIL PERMOHONAN INFORMASI PUBLIK</h1>
        <div class="unique-pill">{{ $permohonan->unique_code }}</div>
    </div>

    <!-- Status & Rating -->
    <table class="status-table">
        <tr>
            <td>
                <span class="badge bg-success">{{ $permohonan->status_permohonan }}</span>
                <span class="badge bg-blue" style="margin-left: 5px;">{{ $permohonan->privacy_status }}</span>
            </td>
            <td style="text-align: right;">
                @if($permohonan->rating)
                    <div style="font-size: 7.5pt; font-weight: bold; color: #94a3b8;">TINGKAT KEPUASAN</div>
                    <div class="stars">
                        @for($i = 0; $i < $permohonan->rating; $i++) &#9733; @endfor
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Section I: Identitas -->
    <div class="section-wrap">
        <div class="section-head">I. Identitas Pemohon</div>
        <table class="grid-table">
            <tr>
                <th>NAMA LENGKAP</th>
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
                <th>KONTAK RESMI</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        DISAMARKAN (KEBIJAKAN PRIVASI)
                    @else
                        {{ $permohonan->email_pemohon ?? '-' }} / {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <!-- Section II: Deskripsi -->
    <div class="section-wrap">
        <div class="section-head">II. Deskripsi Permohonan</div>
        
        <span class="content-label">Informasi yang Dibutuhkan:</span>
        <div class="content-bubble">
            {!! nl2br(e($permohonan->detail_informasi)) !!}
        </div>

        <span class="content-label">Tujuan Penggunaan:</span>
        <div class="content-bubble" style="border-left-color: #64748b;">
            {!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}
        </div>
    </div>

    <!-- Section III: Tanggapan -->
    <div class="section-wrap">
        <div class="section-head">III. Log Tanggapan & Aktivitas</div>
        <div class="timeline-box">
            @forelse($permohonan->responses as $response)
                <div class="tm-item">
                    <div class="tm-dot"></div>
                    <span class="tm-user">{{ strtoupper($response->user->name ?? 'PEMOHON') }}</span>
                    <span class="tm-date">{{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA</span>
                    
                    {{-- Tampilkan Rating jika ini tanggapan pemohon dan ada rating --}}
                    @if($response->user_id == $permohonan->user_id && $permohonan->rating)
                        <span class="stars" style="font-size: 9pt; margin-left: 10px;">
                            @for($i = 0; $i < $permohonan->rating; $i++) &#9733; @endfor
                        </span>
                    @endif

                    <div class="tm-body">
                        {!! nl2br(e($response->message)) !!}
                        
                        @if($response->file_path)
                            <div class="tm-meta-info">
                                LAMPIRAN: {{ basename($response->file_path) }}
                            </div>
                        @endif

                        @if($response->link)
                            <div class="tm-meta-info">
                                LINK TERKAIT: {{ $response->link }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #94a3b8; padding: 10px;">Belum ada tanggapan.</div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-area">
        <table style="width: 100%;">
            <tr>
                <td style="width: 60%; font-size: 8.5pt; color: #64748b; vertical-align: top;">
                    <strong>KONTAK PPID SINJAI:</strong><br>
                    Jl. Persatuan Raya No. 101 Kec. Sinjai Utara,<br>
                    Kabupaten Sinjai, Sulawesi Selatan 92611<br>
                    Telp: 0482-21432 | Email: ppidkabsinjai@gmail.com
                </td>
                <td style="text-align: center; vertical-align: top;">
                    <p style="font-size: 9pt;">Sinjai, {{ date('d F Y') }}</p>
                    <p style="font-weight: bold; margin-top: 5px;">PETUGAS PPID,</p>
                    
                    @php
                        $adminResponse = $permohonan->responses->where('user_id', '!=', $permohonan->user_id)->last();
                        $adminName = ($permohonan->status_permohonan == 'selesai' && $adminResponse) 
                                     ? ($adminResponse->user->name ?? 'ADMIN PPID') 
                                     : 'ADMIN PPID';
                    @endphp
                    
                    <div class="sig-name">{{ $adminName }}</div>
                    <p style="font-size: 7.5pt; color: #94a3b8; margin-top: 10px;">VERIFIED BY SYSTEM v2.5</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
