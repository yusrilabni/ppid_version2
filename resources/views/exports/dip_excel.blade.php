<table>
    <thead>
        <tr>
            <th colspan="9" style="font-weight: bold; font-size: 14px; text-align: center;">DAFTAR INFORMASI PUBLIK (DIP)</th>
        </tr>
        <tr>
            <th colspan="9" style="font-weight: bold; font-size: 12px; text-align: center;">PPID KABUPATEN SINJAI</th>
        </tr>
        @if(isset($unitName))
        <tr>
            <th colspan="9" style="font-weight: bold; font-size: 11px; text-align: center;">{{ strtoupper($unitName) }}</th>
        </tr>
        @endif
        <tr>
            <th colspan="9" style="font-weight: bold; font-size: 11px; text-align: center;">TAHUN ANGGARAN {{ $year }}</th>
        </tr>
        <tr></tr> <!-- Empty row for spacing -->
        <tr style="background-color: #4472C4; color: #FFFFFF; font-weight: bold; border: 1px solid #000000;">
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">No</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Ringkasan Isi Informasi</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Pejabat yang Menguasai Informasi</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Penanggung Jawab Pembuatan Informasi</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Waktu Pembuatan Informasi (Tahun)</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Bentuk Informasi Tersedia</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Jangka Waktu Penyimpanan/Retensi</th>
            <th style="border: 1px solid #000000; text-align: center; vertical-align: middle;">Link Detail</th>
        </tr>
    </thead>
    <tbody>
        @php
            $categories = [
                'Informasi Berkala' => '1. INFORMASI BERKALA',
                'Informasi Setiap Saat' => '2. INFORMASI TERSEDIA SETIAP SAAT',
                'Informasi Serta Merta' => '3. INFORMASI SERTA MERTA'
            ];
            $globalCounter = 1;
        @endphp

        @foreach($categories as $key => $label)
            @if($informasiTahunIni->has($key))
                <tr style="background-color: #D9E1F2; font-weight: bold; border: 1px solid #000000;">
                    <td colspan="9" style="border: 1px solid #000000;">{{ $label }}</td>
                </tr>
                
                @foreach($informasiTahunIni->get($key) as $jenisDokumen => $informasiList)
                    <tr style="background-color: #F2F2F2; font-weight: bold; border: 1px solid #000000;">
                        <td style="border: 1px solid #000000;"></td>
                        <td colspan="8" style="border: 1px solid #000000; color: #305496;">{{ $jenisDokumen ?: 'Lainnya' }}</td>
                    </tr>

                    @foreach($informasiList as $informasi)
                        @php
                            $unitId = trim((string)$informasi->unit_id);
                            $infoUnitName = $unitMap->get($unitId)['unit_nama'] ?? 'N/A';
                            $pejabat = ($infoUnitName == 'Dinas Komunikasi Informatika dan Persandian') ? 'PPID Utama' : 'PPID Pelaksana';
                            $bentuk = !empty($informasi->url) || !empty($informasi->official_id) ? 'Soft Copy' : (!empty($informasi->file) ? 'Hard Copy' : 'N/A');
                            $retensi = in_array(strtoupper(trim($informasi->status)), ['BERLAKU', 'AKTIF']) ? 'Selama Berlaku' : 'Arsip (Tahun ' . $informasi->tahun . ')';
                        @endphp
                        <tr>
                            <td style="border: 1px solid #000000; text-align: center;">{{ $globalCounter++ }}</td>
                            <td style="border: 1px solid #000000;">{{ $informasi->title }}</td>
                            <td style="border: 1px solid #000000;">{{ $pejabat }}</td>
                            <td style="border: 1px solid #000000;">{{ $infoUnitName }}</td>
                            <td style="border: 1px solid #000000; text-align: center;">{{ $informasi->tahun }}</td>
                            <td style="border: 1px solid #000000; text-align: center;">{{ $bentuk }}</td>
                            <td style="border: 1px solid #000000; text-align: center;">{{ $retensi }}</td>
                            <td style="border: 1px solid #000000;">{{ route('frontend.informasi.show', $informasi->id) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>
