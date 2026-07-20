$word = New-Object -ComObject Word.Application
$word.Visible = $false
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
Write-Host "Opening $path"
$doc = $word.Documents.Open($path)
$selection = $word.Selection

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
    @("50% respon netral/negatif", "48,39% respon netral/negatif"),
    @("Tabel 1 Row 9", "") # Dummy
)

foreach ($r in $replaces) {
    if ($r[0] -ne "Tabel 1 Row 9") {
        $selection.Find.ClearFormatting()
        $selection.Find.Text = $r[0]
        $selection.Find.Replacement.Text = $r[1]
        $selection.Find.Wrap = 1
        $selection.Find.Execute([ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, 2)
    }
}

# Update specific table cells (Tabel 1 is item 1)
try {
    $table = $doc.Tables.Item(1)
    # Row 9 (Q8 Error Message) - originally: 96,43% | 0,00% | 0,00% | 0,00% | Sangat Kurang (96,43% menilai tidak jelas)
    # Just to be safe, replace the 96,43% in col 2 of row 9
    $cellText = $table.Cell(9, 2).Range.Text
    if ($cellText -match "96,43") {
        $table.Cell(9, 2).Range.Text = "100%"
    }
    
    # Row 10 (Q9 UI) - originally: 0,00% | 50,00% | 25,00% | 25,00% 
    $table.Cell(10, 3).Range.Text = "48,39%"
    $table.Cell(10, 4).Range.Text = "25,81%"
    $table.Cell(10, 5).Range.Text = "25,81%"
} catch {
    Write-Host "Error updating table 1: $_"
}

# Add recommendations
$selection.Find.ClearFormatting()
$selection.Find.Text = "Pengembangan Aplikasi Mobile"
if (-not $selection.Find.Execute()) {
    $selection.Find.ClearFormatting()
    $selection.Find.Text = "setelah koneksi kembali stabil."
    if ($selection.Find.Execute()) {
        $selection.Collapse(0) # End of matched text
        $selection.TypeParagraph()
        $selection.TypeText("4. Pengembangan Aplikasi Mobile (Mobile App): Berdasarkan usulan operator, pengembangan aplikasi PPID berbasis mobile (Android) sangat disarankan. Aplikasi smartphone dinilai jauh lebih praktis dan fleksibel bagi operator yang mobilitasnya tinggi, sehingga proses pelaporan tidak harus bergantung pada ketersediaan komputer desktop di kantor.")
        $selection.TypeParagraph()
        $selection.TypeText("5. Sistem Notifikasi Pintar Terintegrasi: Pembuatan modul pemberitahuan (push notification) untuk menyebarluaskan berita terbaru, pembaruan aturan, atau peringatan kelengkapan dokumen secara langsung ke dashboard (atau aplikasi mobile) para admin OPD. Hal ini akan mengurangi ketergantungan pada koordinasi manual.")
    }
}

$doc.Save()
Write-Host "Saved successfully"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
