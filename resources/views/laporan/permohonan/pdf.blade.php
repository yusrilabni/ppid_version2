<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Permohonan Informasi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 10px;
            padding: 0;
            line-height: 1.2;
        }

        /* HEADER */
        .header-container {
            text-align: center;
            margin: 0 0 8px 0;
            padding: 0;
        }

        .logo-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #4f46e5 100%);
            margin: 0 auto 5px auto;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-circle img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
        }

        .header-title {
            font-size: 22px;
            color: #000;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 1;
        }

        .header-subtitle {
            font-size: 11px;
            color: #666;
            margin: 2px 0 0 0;
            padding: 0;
        }

        /* BADGES */
        .badges-container {
            text-align: center;
            margin: 3px 0 5px 0;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            margin: 0 3px;
        }

        .status-selesai {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .privacy-publik {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        /* SECTION TITLE */
        .section-title {
            background-color: #e8eaf6;
            color: #1a237e;
            padding: 6px 8px;
            margin: 10px 0 5px 0;
            font-size: 13px;
            font-weight: bold;
            border-left: 4px solid #1a237e;
        }

        /* TABEL - Perbaikan utama */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table th {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 6px 8px;
            width: 30%;
            font-weight: bold;
            font-size: 12px;
            text-align: left;
        }

        .info-table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            font-size: 12px;
            text-align: left;
        }

        /* CONTENT BLOCKS */
        .content-block {
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            margin-bottom: 8px;
            font-size: 12px;
            line-height: 1.4;
        }

        /* RESPONSE BLOCKS */
        .response-block {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            margin-bottom: 8px;
        }

        .response-header {
            font-weight: bold;
            color: #333;
            font-size: 12px;
        }

        .response-date {
            font-size: 10px;
            color: #666;
            margin-left: 8px;
        }

        .response-content {
            font-size: 12px;
            line-height: 1.4;
        }

        .attachment-link {
            font-size: 11px;
            color: #1565c0;
        }

        .no-response {
            font-style: italic;
            color: #888;
            font-size: 11px;
            text-align: center;
            padding: 8px;
        }

        /* LABEL STYLING */
        .label {
            font-weight: bold;
            margin: 5px 0;
            display: block;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="header-container">
        <div class="logo-circle">
            <img src="{{ $ppidLogoBase64 }}" alt="Logo PPID">
        </div>
        <div class="header-title">Detail Permohonan Informasi</div>
        <div class="header-subtitle">Lihat rincian lengkap permohonan informasi Anda, termasuk status dan riwayat
            tanggapan.</div>
    </div>

    <!-- BADGES -->
    <div class="badges-container">
        @php
            $statusClass = [
                'selesai' => 'status-selesai',
                'diproses' => 'status-diproses',
                'pending' => 'status-pending',
                'ditolak' => 'status-ditolak',
            ];
            $privacyClass = [
                'Publik' => 'privacy-publik',
                'Anonim' => 'privacy-anonim',
                'Rahasia' => 'privacy-rahasia',
            ];
        @endphp
        <span class="badge {{ $statusClass[$permohonan->status_permohonan] ?? 'status-pending' }}">
            {{ ucfirst($permohonan->status_permohonan) }}
        </span>
        <span class="badge {{ $privacyClass[$permohonan->privacy_status] ?? 'privacy-publik' }}">
            {{ $permohonan->privacy_status }}
        </span>
    </div>

    <!-- CONTENT -->
    <div>
        <div class="section-title">A. Detail Permohonan</div>
        <table class="info-table">
            <tr>
                <th>Kode Permohonan</th>
                <td>{{ $permohonan->unique_code }}</td>
            </tr>
            <tr>
                <th>Tanggal Permohonan</th>
                <td>{{ $permohonan->created_at->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Status Permohonan</th>
                <td>{{ ucfirst($permohonan->status_permohonan) }}</td>
            </tr>
            <tr>
                <th>Rating Kepuasan</th>
                <td>{{ $permohonan->rating ? $permohonan->rating . ' dari 5' : 'Belum dinilai' }}</td>
            </tr>
        </table>

        <div class="section-title">B. Informasi Pemohon</div>
        <table class="info-table">
            <tr>
                <th>Nama Pemohon</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        {{ substr($permohonan->nama_pemohon, 0, 1) . '*****' }}
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
                <th>Nomor Telepon</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        {{ substr($permohonan->nomor_telepon_pemohon, 0, 3) . '*****' }}
                    @else
                        {{ $permohonan->nomor_telepon_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Email</th>
                <td>
                    @if ($permohonan->privacy_status == 'Anonim')
                        {{ substr($permohonan->email_pemohon, 0, 3) . '*****' }}
                    @else
                        {{ $permohonan->email_pemohon ?? '-' }}
                    @endif
                </td>
            </tr>
        </table>

        <div class="section-title">C. Rincian Permohonan</div>
        <span class="label">Informasi yang Dibutuhkan:</span>
        <div class="content-block">{{ $permohonan->detail_informasi }}</div>

        <span class="label">Tujuan Penggunaan Informasi:</span>
        <div class="content-block">{{ $permohonan->tujuan_penggunaan_informasi }}</div>

        @php
            $caraMemperoleh = json_decode($permohonan->cara_memperoleh_informasi, true);
            $caraSalinan = json_decode($permohonan->cara_mendapatkan_salinan, true);
        @endphp

        @if (!empty($caraMemperoleh) || !empty($caraSalinan))
            <div class="section-title">D. Cara Memperoleh dan Mendapatkan Salinan</div>

            @if (!empty($caraMemperoleh))
                <span class="label">Cara Memperoleh Informasi:</span>
                <div class="content-block">
                    @foreach ($caraMemperoleh as $cara)
                        • {{ $cara }}<br>
                    @endforeach
                </div>
            @endif

            @if (!empty($caraSalinan))
                <span class="label">Cara Mendapatkan Salinan:</span>
                <div class="content-block">
                    @foreach ($caraSalinan as $cara)
                        • {{ $cara }}<br>
                    @endforeach
                </div>
            @endif

            @if ($permohonan->tempat_mendapatkan_salinan)
                <span class="label">Tempat Mendapatkan Salinan:</span>
                <div class="content-block">{{ $permohonan->tempat_mendapatkan_salinan }}</div>
            @endif
        @endif

        <div class="section-title">E. Riwayat Tanggapan</div>
        @if ($permohonan->responses->count() > 0)
            @foreach ($permohonan->responses as $response)
                <div class="response-block">
                    <div class="response-header">
                        {{ $response->user->name ?? 'Admin' }}
                        <span class="response-date">{{ $response->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="response-content">{{ $response->message }}</div>
                    @if ($response->file_path)
                        <div class="attachment-link"><strong>Lampiran:</strong> File terlampir</div>
                    @endif
                    @if ($response->link)
                        <div class="attachment-link"><strong>Link:</strong> {{ $response->link }}</div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="no-response">Belum ada tanggapan.</div>
        @endif
    </div>

</body>

</html>
