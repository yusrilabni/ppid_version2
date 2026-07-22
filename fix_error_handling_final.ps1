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

Replace-Text "Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%)." "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif (100% menjawab Ya)."
Replace-Text "Namun, penanganan kesalahan (error handling) dinilai belum informatif" "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif"
Replace-Text "Rekomendasi utama mencakup perbaikan pesan kesalahan dan pengembangan fitur pemantauan" "Rekomendasi utama berfokus pada pengembangan fitur pemantauan"
Replace-Text "Rekomendasi utama mencakup perbaikan pesan kesalahan, dan pengembangan fitur pemantauan" "Rekomendasi utama berfokus pada pengembangan fitur pemantauan"

Replace-Text "However, error handling was deemed uninformative (100%)." "Additionally, the error handling system was deemed highly informative (100% Yes)."
Replace-Text "However, error handling was deemed uninformative" "Additionally, the error handling system was deemed highly informative"
Replace-Text "The main recommendations include improving error messages and adding a self-monitoring" "The main recommendations focus on adding a self-monitoring"
Replace-Text "The main recommendations include improving error messages, and adding a self-monitoring" "The main recommendations focus on adding a self-monitoring"

Replace-Text "sistem penanganan kesalahan (error handling) yang dinilai belum jelas oleh 100% responden" "sistem penanganan kesalahan (error handling) yang dinilai sangat jelas oleh 100% responden"
Replace-Text "Sistem penanganan kesalahan (error handling) yang dinilai belum jelas oleh 100% responden" "Sistem penanganan kesalahan (error handling) yang dinilai sangat jelas oleh 100% responden"

Replace-Text "Sistem Pesan Kesalahan (Error Handling) yang Buruk (Temuan Utama)" "Keberhasilan Sistem Pesan Kesalahan (Error Handling)"
Replace-Text "Sistem Pesan Kesalahan (Error Handling) yang Buruk" "Keberhasilan Sistem Pesan Kesalahan (Error Handling)"

Replace-Text "memberikan skor terendah (skor 1) pada kejelasan pesan kesalahan yang dimunculkan oleh sistem saat terjadi kekeliruan pengisian." "menyatakan 'Ya' (100%) terhadap kejelasan pesan kesalahan yang dimunculkan oleh sistem saat terjadi kekeliruan pengisian."
Replace-Text "Hal ini menunjukkan bahwa sistem tidak memberikan instruksi perbaikan yang jelas ketika terjadi kegagalan validasi formulir" "Hal ini menunjukkan bahwa sistem telah berhasil memberikan instruksi perbaikan yang sangat jelas ketika terjadi kegagalan validasi formulir"
Replace-Text "Dampak dari temuan ini adalah admin OPD mengalami kebingungan dan frustrasi karena harus menebak-nebak letak kesalahan input data mereka." "Dampaknya, admin OPD merasa sangat terbantu dan tidak mengalami kebingungan saat harus memperbaiki kesalahan input data mereka."

Replace-Text "kelemahan kritis pada fitur penanganan kesalahan (error handling) yang tidak informatif bagi pengguna (100% tidak setuju)" "keberhasilan pada fitur penanganan kesalahan (error handling) yang sangat informatif bagi pengguna (100% merespons Ya)"

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done"
