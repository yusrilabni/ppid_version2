$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)
$missing = [System.Reflection.Missing]::Value

function Replace-Text {
    param([string]$find, [string]$replace)
    $selection = $word.Selection
    $selection.HomeKey(6) | Out-Null
    $selection.Find.ClearFormatting()
    $selection.Find.Replacement.ClearFormatting()
    $selection.Find.Text = $find
    $selection.Find.Replacement.Text = $replace
    $selection.Find.Execute([ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]1, [ref]$missing, [ref]$missing, [ref]2) | Out-Null
}

# Abstrak ID
Replace-Text "Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%). Rekomendasi utama mencakup perbaikan pesan kesalahan, dan pengembangan" "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif (100% menjawab Ya). Rekomendasi utama berfokus pada pengembangan"
Replace-Text "Namun, terdapat beberapa temuan kritis terkait aspek usability, di antaranya adalah sistem penanganan kesalahan (error handling) yang dinilai belum jelas oleh 100% responden, serta antarmuka visual (interface) juga telah dinilai sangat memuaskan (100% menilai sangat baik). Rekomendasi utama mencakup perbaikan pesan kesalahan, dan pengembangan" "Selain itu, penanganan kesalahan (error handling) dan antarmuka visual (interface) juga dinilai sangat memuaskan (100% menilai jelas dan sangat baik). Rekomendasi utama dari penelitian ini difokuskan pada pengembangan"

# Abstrak EN
Replace-Text "However, error handling was deemed uninformative (100%). The main recommendations include improving error messages, and adding" "Additionally, the error handling system was deemed highly informative (100% Yes). The main recommendations focus on adding"
Replace-Text "However, there are some critical findings related to usability aspects, including the error handling system, which was rated as unclear by 100% of respondents, and the visual interface, was rated highly satisfactory (100% rated as excellent). The main recommendations include improving error messages, and adding" "Additionally, both the error handling system and the visual interface were rated highly satisfactory (100% rated as clear and excellent). The main recommendations focus on adding"

# Section 4.3
Replace-Text "Sistem Pesan Kesalahan (Error Handling) yang Buruk (Temuan Utama)" "Keberhasilan Sistem Pesan Kesalahan (Error Handling)"
Replace-Text "memberikan skor terendah (skor 1) pada kejelasan pesan kesalahan yang dimunculkan oleh sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem tidak memberikan instruksi perbaikan yang jelas ketika terjadi kegagalan validasi formulir (misalnya format file salah atau ukuran melebihi batas). Dampak dari temuan ini adalah admin OPD mengalami kebingungan dan frustrasi karena harus menebak-nebak letak kesalahan input data mereka." "menyatakan 'Ya' (100%) terhadap kejelasan pesan kesalahan yang dimunculkan sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem telah berhasil memberikan instruksi perbaikan yang sangat jelas ketika terjadi kegagalan validasi formulir, sehingga admin OPD merasa sangat terbantu dan tidak kebingungan saat memperbaiki kesalahan input data."

# Section 5.1
Replace-Text "Namun, dari aspek usability, sistem ini masih memiliki kelemahan kritis pada fitur penanganan kesalahan (error handling) yang tidak informatif bagi pengguna (100% tidak setuju) ditambah lagi dengan tampilan antarmuka visual dashboard admin yang dinilai telah sangat mempermudah pekerjaan (100% respon positif)." "Dari aspek usability, sistem penanganan kesalahan (error handling) terbukti sangat informatif (100% merespons Ya), didukung dengan tampilan antarmuka visual dashboard admin yang dinilai telah sangat mempermudah pekerjaan harian (100% respon positif)."

# Table 1
try {
    $table = $doc.Tables.Item(1)
    $table.Cell(9, 3).Range.Text = "0,00%"
    $table.Cell(9, 4).Range.Text = "0,00%"
    $table.Cell(9, 5).Range.Text = "0,00%"
    $table.Cell(9, 6).Range.Text = "100%"
    $table.Cell(9, 7).Range.Text = "Sangat Baik (100% merespons Ya)"
} catch {}

Replace-Text "Pertanyaan produktivitas menggunakan jawaban pilihan tunggal (Ya = 100%)" "Indikator produktivitas dan pesan kesalahan diukur menggunakan format biner (Ya/Tidak, di mana Ya = 100%)"
Replace-Text "Indikator produktivitas diukur menggunakan pilihan biner Ya/Tidak (Ya = 100%)" "Indikator produktivitas dan pesan kesalahan diukur menggunakan format biner (Ya/Tidak, di mana Ya = 100%)"

# Section 5.2 Remove error handling rec
$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "Perbaikan Error Handling:"
if ($selection.Find.Execute()) {
    $selection.Paragraphs.Item(1).Range.Delete()
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
