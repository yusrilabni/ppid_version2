$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

$count = $doc.Paragraphs.Count
for ($i = 1; $i -le $count; $i++) {
    $para = $doc.Paragraphs.Item($i)
    $text = $para.Range.Text
    $updated = $false

    if ($text -match "belum informatif \(100%\)\.") {
        $text = $text.Replace("Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%). Rekomendasi utama mencakup perbaikan pesan kesalahan, dan pengembangan", "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif (100% menjawab Ya). Rekomendasi utama berfokus pada pengembangan")
        $updated = $true
    }
    if ($text -match "dinilai belum jelas oleh 100% responden") {
        $text = $text.Replace("Namun, terdapat beberapa temuan kritis terkait aspek usability, di antaranya adalah sistem penanganan kesalahan (error handling) yang dinilai belum jelas oleh 100% responden, serta antarmuka visual (interface) juga telah dinilai sangat memuaskan (100% menilai sangat baik). Rekomendasi utama mencakup perbaikan pesan kesalahan, dan pengembangan", "Selain itu, penanganan kesalahan (error handling) dan antarmuka visual (interface) juga dinilai sangat memuaskan (100% menilai jelas dan sangat baik). Rekomendasi utama dari penelitian ini difokuskan pada pengembangan")
        $updated = $true
    }
    if ($text -match "uninformative \(100%\)\.") {
        $text = $text.Replace("However, error handling was deemed uninformative (100%). The main recommendations include improving error messages, and adding", "Additionally, the error handling system was deemed highly informative (100% Yes). The main recommendations focus on adding")
        $updated = $true
    }
    if ($text -match "rated as unclear by 100% of respondents") {
        $text = $text.Replace("However, there are some critical findings related to usability aspects, including the error handling system, which was rated as unclear by 100% of respondents, and the visual interface, was rated highly satisfactory (100% rated as excellent). The main recommendations include improving error messages, and adding", "Additionally, both the error handling system and the visual interface were rated highly satisfactory (100% rated as clear and excellent). The main recommendations focus on adding")
        $updated = $true
    }
    if ($text -match "Sistem Pesan Kesalahan \(Error Handling\) yang Buruk") {
        $text = $text.Replace("Sistem Pesan Kesalahan (Error Handling) yang Buruk (Temuan Utama)", "Keberhasilan Sistem Pesan Kesalahan (Error Handling)")
        $updated = $true
    }
    if ($text -match "skor terendah \(skor 1\)") {
        $text = $text.Replace("memberikan skor terendah (skor 1) pada kejelasan pesan kesalahan yang dimunculkan oleh sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem tidak memberikan instruksi perbaikan yang jelas ketika terjadi kegagalan validasi formulir (misalnya format file salah atau ukuran melebihi batas). Dampak dari temuan ini adalah admin OPD mengalami kebingungan dan frustrasi karena harus menebak-nebak letak kesalahan input data mereka.", "menyatakan 'Ya' (100%) terhadap kejelasan pesan kesalahan yang dimunculkan sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem telah berhasil memberikan instruksi perbaikan yang sangat jelas ketika terjadi kegagalan validasi formulir, sehingga admin OPD merasa sangat terbantu dan tidak kebingungan saat memperbaiki kesalahan input data.")
        $updated = $true
    }
    if ($text -match "kelemahan kritis pada fitur penanganan kesalahan") {
        $text = $text.Replace("Namun, dari aspek usability, sistem ini masih memiliki kelemahan kritis pada fitur penanganan kesalahan (error handling) yang tidak informatif bagi pengguna (100% tidak setuju) ditambah lagi dengan tampilan antarmuka visual dashboard admin yang dinilai telah sangat mempermudah pekerjaan (100% respon positif).", "Dari aspek usability, sistem penanganan kesalahan (error handling) terbukti sangat informatif (100% merespons Ya), didukung dengan tampilan antarmuka visual dashboard admin yang dinilai telah sangat mempermudah pekerjaan harian (100% respon positif).")
        $updated = $true
    }
    if ($text -match "Pertanyaan produktivitas menggunakan jawaban pilihan tunggal") {
        $text = $text.Replace("Pertanyaan produktivitas menggunakan jawaban pilihan tunggal (Ya = 100%)", "Indikator produktivitas dan pesan kesalahan diukur menggunakan format biner (Ya/Tidak, di mana Ya = 100%)")
        $updated = $true
    }
    if ($text -match "Indikator produktivitas diukur menggunakan pilihan biner Ya/Tidak") {
        $text = $text.Replace("Indikator produktivitas diukur menggunakan pilihan biner Ya/Tidak (Ya = 100%)", "Indikator produktivitas dan pesan kesalahan diukur menggunakan format biner (Ya/Tidak, di mana Ya = 100%)")
        $updated = $true
    }
    if ($text -match "Perbaikan Error Handling:") {
        $para.Range.Delete()
        $nextPara = $doc.Paragraphs.Item($i) 
        if ($nextPara -and $nextPara.Range.Text -match "pesan kesalahan yang kurang jelas") {
            $nextPara.Range.Delete()
            $count = $count - 2
            $i = $i - 1
        }
        $updated = $false
    }

    if ($updated) {
        $para.Range.Text = $text
    }
}

try {
    $table = $doc.Tables.Item(1)
    $table.Cell(9, 3).Range.Text = "0,00%"
    $table.Cell(9, 4).Range.Text = "0,00%"
    $table.Cell(9, 5).Range.Text = "0,00%"
    $table.Cell(9, 6).Range.Text = "100%"
    $table.Cell(9, 7).Range.Text = "Sangat Baik (100% merespons Ya)"
} catch {}


$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done Fix V3"
