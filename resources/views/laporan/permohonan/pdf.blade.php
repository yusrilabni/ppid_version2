<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Permohonan - {{ $permohonan->unique_code }}</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
            padding: 1cm;
            color: #1e293b;
            background-color: #ffffff;
            line-height: 1.5;
            font-size: 10pt;
        }
        /* Color Palette */
        .text-primary { color: #1e3a8a; }
        .bg-primary { background-color: #1e3a8a; }
        .bg-slate { background-color: #f8fafc; }
        
        /* Header Section */
        .header-table {
            width: 100%;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .app-title {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            color: #1e3a8a;
            text-align: right;
        }
        .office-info {
            font-size: 8pt;
            color: #64748b;
            text-align: right;
            margin-top: 5px;
            line-height: 1.3;
        }

        /* Title Area */
        .title-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .document-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .unique-code {
            font-family: monospace;
            font-size: 12pt;
            color: #1e3a8a;
            background: #dbeafe;
            padding: 3px 15px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Status & Rating Bar */
        .status-bar {
            width: 100%;
            margin-bottom: 20px;
        }
        .badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 8pt;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
        }
        .badge-success { background-color: #10b981; }
        .badge-info { background-color: #3b82f6; }
        
        .rating-stars {
            color: #f59e0b;
            font-weight: bold;
            font-size: 11pt;
        }

        /* Section Layout */
        .section-header {
            background-color: #1e3a8a;
            color: white;
            padding: 6px 12px;
            font-weight: bold;
            font-size: 10pt;
            margin-top: 20px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table th {
            width: 30%;
            text-align: left;
            padding: 8px;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 9pt;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        /* Content Boxes */
        .content-label {
            font-weight: bold;
            font-size: 8pt;
            color: #64748b;
            margin-top: 10px;
            display: block;
        }
        .content-value {
            border: 1px solid #e2e8f0;
            padding: 10px;
            background-color: #f8fafc;
            border-radius: 4px;
            margin-top: 4px;
        }

        /* Response History */
        .response-item {
            border-left: 3px solid #cbd5e1;
            padding-left: 15px;
            margin-bottom: 15px;
            position: relative;
        }
        .response-meta {
            font-size: 8pt;
            color: #64748b;
            margin-bottom: 3px;
        }
        .response-user {
            font-weight: bold;
            color: #1e293b;
        }
        .response-msg {
            font-size: 9pt;
            color: #334155;
        }

        /* Signature Section */
        .footer-section {
            margin-top: 40px;
        }
        .signature-table {
            width: 100%;
        }
        .signature-cell {
            width: 40%;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header Office Info -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                @if(!empty($ppidLogoBase64))
                    <img src="{{ $ppidLogoBase64 }}" style="width: 120px;">
                @else
                    <div style="font-weight: bold; font-size: 20pt; color: #1e3a8a;">PPID</div>
                @endif
            </td>
            <td style="vertical-align: middle;">
                <h1 class="app-title">PPID KABUPATEN SINJAI</h1>
                <div class="office-info">
                    Jl. Persatuan Raya No. 101 Kec. Sinjai Utara, Kab. Sinjai, Sulawesi Selatan 92611<br>
                    Telepon: 0482-21432 | Email: ppidkabsinjai@gmail.com
                </div>
            </td>
        </tr>
    </table>

    <!-- Document Title -->
    <div class="title-container">
        <div class="document-title">Rincian Permohonan Informasi Publik</div>
        <div class="unique-code">{{ $permohonan->unique_code }}</div>
    </div>

    <!-- Status & Rating -->
    <table style="width: 100%; margin-bottom: 10px;">
        <tr>
            <td>
                <span class="badge badge-success">{{ $permohonan->status_permohonan }}</span>
                <span class="badge badge-info">{{ $permohonan->privacy_status }}</span>
            </td>
            <td style="text-align: right;">
                @if($permohonan->rating)
                    <span style="font-size: 8pt; color: #64748b;">Rating Kepuasan: </span>
                    <span class="rating-stars">
                        @for($i = 0; $i < $permohonan->rating; $i++) ★ @endfor
                        <span style="color: #cbd5e1;">@for($i = 0; $i < (5 - $permohonan->rating); $i++) ★ @endfor</span>
                    </span>
                @endif
            </td>
        </tr>
    </table>

    <!-- I. Identitas Pemohon -->
    <div class="section-header">I. IDENTITAS PEMOHON</div>
    <table class="info-table">
        <tr>
            <th>Nama Lengkap</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    <span style="color: #94a3b8; font-style: italic;">[Data Disamarkan Sistem]</span>
                @else
                    {{ $permohonan->nama_pemohon }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $permohonan->alamat_pemohon }}</td>
        </tr>
        <tr>
            <th>Pekerjaan</th>
            <td>{{ $permohonan->pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <th>Kontak</th>
            <td>
                @if ($permohonan->privacy_status == 'Anonim')
                    ***-**** / *****@***
                @else
                    {{ $permohonan->nomor_telepon_pemohon ?? '-' }} / {{ $permohonan->email_pemohon ?? '-' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- II. Isi Permohonan -->
    <div class="section-header">II. RINCIAN PERMOHONAN</div>
    <span class="content-label">INFORMASI YANG DIBUTUHKAN:</span>
    <div class="content-value">{!! nl2br(e($permohonan->detail_informasi)) !!}</div>

    <span class="content-label">TUJUAN PENGGUNAAN:</span>
    <div class="content-value">{!! nl2br(e($permohonan->tujuan_penggunaan_informasi)) !!}</div>

    <!-- III. Riwayat Tanggapan -->
    <div class="section-header">III. RIWAYAT TANGGAPAN ADMIN</div>
    <div style="padding: 10px; border: 1px solid #e2e8f0; border-radius: 4px;">
        @forelse($permohonan->responses as $response)
            <div class="response-item">
                <div class="response-meta">
                    <span class="response-user">{{ $response->user->name ?? 'Admin PPID' }}</span> | 
                    {{ $response->created_at->translatedFormat('d M Y, H:i') }} WITA
                </div>
                <div class="response-msg">{!! nl2br(e($response->message)) !!}</div>
            </div>
        @empty
            <div style="text-align: center; color: #94a3b8; font-style: italic; font-size: 9pt;">Belum ada tanggapan resmi.</div>
        @endforelse
    </div>

    <!-- Signature Area -->
    <div class="footer-section">
        <table class="signature-table">
            <tr>
                <td style="width: 60%;"></td>
                <td class="signature-cell">
                    <p style="font-size: 9pt;">Sinjai, {{ now()->translatedFormat('d F Y') }}</p>
                    <p style="font-weight: bold; margin-top: 5px;">Petugas PPID Sinjai,</p>
                    <div class="signature-space"></div>
                    @php
                        // Ambil nama admin yang terakhir memberikan tanggapan jika status sudah selesai
                        $lastResponse = $permohonan->responses->last();
                        $adminName = ($permohonan->status_permohonan == 'selesai' && $lastResponse) 
                                     ? ($lastResponse->user->name ?? 'Admin PPID') 
                                     : 'Admin PPID';
                    @endphp
                    <p class="signature-name">{{ strtoupper($adminName) }}</p>
                    <p style="font-size: 7pt; color: #94a3b8; margin-top: 5px;">Dicetak otomatis melalui Sistem PPID</p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

