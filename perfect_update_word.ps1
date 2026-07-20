$word = New-Object -ComObject Word.Application
$word.Visible = $false
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path)
$missing = [System.Reflection.Missing]::Value

$replaces = @(
    @("kepada 28 responden", "kepada 31 responden"),
    @("96,43% responden", "100% responden"),
    @("50% menilai cukup/kurang", "48,39% menilai cukup/kurang"),
    @("to 28 respondents", "to 31 respondents"),
    @("96.43% of respondents", "100% of respondents"),
    @("50% rated as average/poor", "48.39% rated as average/poor"),
    @("28 orang yang merupakan", "31 orang yang merupakan"),
    @("dari 28 responden admin", "dari 31 responden admin"),
    @("50,00% (14 orang)", "48,39% (15 orang)"),
    @("17,86% (5 orang)", "16,13% (5 orang)"),
    @("32,14% (9 orang)", "35,48% (11 orang)"),
    @("57,14% (16 orang)", "51,61% (16 orang)"),
    @("21,43% (6 orang)", "19,35% (6 orang)"),
    @("64,29% (18 orang)", "61,29% (19 orang)"),
    @("35,71% (10 orang)", "38,71% (12 orang)"),
    @("96,43% menilai tidak jelas", "100% menilai tidak jelas"),
    @("50% menilai skor 2", "48,39% menilai skor 2"),
    @("Sebanyak 96,43% responden", "Sebanyak 100% responden"),
    @("Sebanyak 50,00% responden", "Sebanyak 48,39% responden"),
    @("96,43% tidak setuju", "100% tidak setuju"),
    @("50% respon netral/negatif", "48,39% respon netral/negatif")
)

foreach ($r in $replaces) {
    $selection = $word.Selection
    $selection.HomeKey(6) | Out-Null # wdStory
    $selection.Find.ClearFormatting()
    $selection.Find.Replacement.ClearFormatting()
    $selection.Find.Text = $r[0]
    $selection.Find.Replacement.Text = $r[1]
    $selection.Find.Execute([ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]1, [ref]$missing, [ref]$missing, [ref]2) | Out-Null
}

try {
    $table = $doc.Tables.Item(1)
    $table.Cell(2, 2).Range.Text = "12,90%"
    $table.Cell(2, 3).Range.Text = "16,13%"
    $table.Cell(2, 4).Range.Text = "51,61%"
    $table.Cell(2, 5).Range.Text = "19,35%"
    
    $table.Cell(9, 2).Range.Text = "100%"
    
    $table.Cell(10, 3).Range.Text = "48,39%"
    $table.Cell(10, 4).Range.Text = "25,81%"
    $table.Cell(10, 5).Range.Text = "25,81%"
} catch {}

# Add Recommendations
$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "koneksi kembali stabil."
if ($selection.Find.Execute()) {
    $selection.Collapse(0)
    $selection.TypeParagraph()
    $selection.TypeText("4. Pengembangan Aplikasi Mobile (Mobile App): Berdasarkan usulan operator, pengembangan aplikasi PPID berbasis mobile (Android) sangat disarankan. Aplikasi smartphone dinilai jauh lebih praktis dan fleksibel bagi operator yang mobilitasnya tinggi, sehingga proses pelaporan tidak harus bergantung pada ketersediaan komputer desktop di kantor.")
    $selection.TypeParagraph()
    $selection.TypeText("5. Sistem Notifikasi Pintar Terintegrasi: Pembuatan modul pemberitahuan (push notification) untuk menyebarluaskan berita terbaru, pembaruan aturan, atau peringatan kelengkapan dokumen secara langsung ke dashboard (atau aplikasi mobile) para admin OPD. Hal ini akan mengurangi ketergantungan pada koordinasi manual.")
}

$doc.Save()
Write-Host "Saved successfully!"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
