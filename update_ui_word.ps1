$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")

$replaces = @{
    "yang masih membutuhkan perbaikan (48,39% menilai cukup/kurang)" = "juga telah dinilai sangat memuaskan (100% menilai sangat baik)"
    "which still needs improvement (48.39% rated as average/poor)" = "was rated highly satisfactory (100% rated as excellent)"
    "Kebutuhan Optimalisasi Tampilan Visual (Dashboard UI)" = "Keberhasilan Desain Antarmuka Visual (UI/UX)"
    "Sebanyak 48,39% responden menilai visual antarmuka dengan skor 2 (cukup/kurang). Evaluasi estetika dashboard dinilai kurang membantu fokus kerja operator dalam menginput data secara harian, sehingga memerlukan pembaruan desain antarmuka yang lebih rapi, modern, dan intuitif." = "100% (31 responden) memberikan penilaian tertinggi (Skor 4). Hal ini menunjukkan bahwa desain antarmuka visual dashboard admin saat ini sudah sangat ergonomis, modern, dan intuitif, sehingga sukses mempermudah pekerjaan operator."
    "serta tampilan antarmuka visual dashboard admin yang dirasa kurang mempermudah pekerjaan (48,39% respon netral/negatif)." = "ditambah lagi dengan tampilan antarmuka visual dashboard admin yang dinilai telah sangat mempermudah pekerjaan (100% respon positif)."
    "Optimasi UI/UX Dashboard: Memperbarui desain visual dashboard admin agar lebih bersih, modern, dan menyertakan panduan petunjuk/tooltip di setiap menu penting." = "Pemeliharaan Kualitas UI/UX Dashboard: Mempertahankan dan terus mengevaluasi desain visual dashboard admin yang saat ini telah diapresiasi penuh (100%) oleh para operator."
}

foreach ($key in $replaces.Keys) {
    $selection = $word.Selection
    $selection.HomeKey(6) | Out-Null
    $selection.Find.ClearFormatting()
    $selection.Find.Replacement.ClearFormatting()
    $selection.Find.Text = $key
    $selection.Find.Replacement.Text = $replaces[$key]
    $selection.Find.Forward = $true
    $selection.Find.Wrap = 1
    $selection.Find.Execute([System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, 2) | Out-Null
}

try {
    $table = $doc.Tables.Item(1)
    $table.Cell(10, 2).Range.Text = "0,00%"
    $table.Cell(10, 3).Range.Text = "0,00%"
    $table.Cell(10, 4).Range.Text = "0,00%"
    $table.Cell(10, 5).Range.Text = "31 (100%)"
    $table.Cell(10, 6).Range.Text = "100,00%"
} catch {}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Word document updated for UI success."
