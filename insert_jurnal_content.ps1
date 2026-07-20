$word = New-Object -ComObject Word.Application
$word.Visible = $false
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path)
$missing = [System.Reflection.Missing]::Value

# 1. Pendahuluan - Masalah awal website lama
$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "mengimplementasikan pengembangan dan optimalisasi aplikasi berbasis web PPID sebagai langkah peningkatan layanan dari sistem sebelumnya."
if ($selection.Find.Execute()) {
    $selection.Collapse(0) # Collapse to end
    $selection.TypeText(" Optimalisasi ini sangat diperlukan karena sistem sebelumnya memiliki berbagai kelemahan mendasar, seperti klasifikasi dokumen yang masih manual dan rentan salah, tidak adanya fitur validasi kelengkapan atribut dokumen sebelum diunggah, serta antarmuka yang kurang responsif sehingga cukup menyulitkan admin OPD dalam pelaporan rutin.")
}

# 2. Akhir pendahuluan - Alasan menggunakan teori Usability dan TAM
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "fitur dan antarmuka sistem di masa mendatang."
if ($selection.Find.Execute()) {
    $selection.Collapse(0)
    $selection.TypeText(" Penggunaan metode evaluasi Usability dan Technology Acceptance Model (TAM) dipilih sebagai pisau analisis dalam penelitian ini karena kombinasi kedua pendekatan tersebut sangat komprehensif. Pendekatan usability secara presisi mengukur interaksi fisik dan kemudahan operasional tanpa error, sementara TAM secara psikologis mengevaluasi tingkat penerimaan pengguna akhir serta dampak pembaruan sistem terhadap peningkatan produktivitas kerja admin OPD.")
}

# 3. Pembahasan - Placeholder gambar UI lama dan baru
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "demi efisiensi birokrasi."
if ($selection.Find.Execute()) {
    $selection.Collapse(0)
    $selection.TypeParagraph()
    $selection.TypeParagraph()
    $selection.TypeText("4.4. Perbandingan Antarmuka (UI) Sistem Lama dan Sistem Hasil Optimalisasi")
    $selection.TypeParagraph()
    $selection.TypeText("Untuk memberikan gambaran yang lebih transparan mengenai signifikansi pembaruan yang dilakukan, berikut disajikan perbandingan visual antara antarmuka website PPID sebelum dan setelah dilakukan optimalisasi.")
    $selection.TypeParagraph()
    $selection.TypeParagraph()
    $selection.TypeText("[TEMPAT FOTO - SCREENSHOT WEBSITE PPID LAMA SEBELUM OPTIMALISASI]")
    $selection.TypeParagraph()
    $selection.TypeText("Gambar 1. Tampilan Antarmuka Website PPID Sebelum Optimalisasi (Sistem Lama)")
    $selection.TypeParagraph()
    $selection.TypeParagraph()
    $selection.TypeText("[TEMPAT FOTO - SCREENSHOT WEBSITE PPID BARU SETELAH OPTIMALISASI]")
    $selection.TypeParagraph()
    $selection.TypeText("Gambar 2. Tampilan Antarmuka Website PPID Setelah Optimalisasi (Sistem Baru)")
    $selection.TypeParagraph()
}

$doc.Save()
Write-Host "Update jurnal.docx berhasil!"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
