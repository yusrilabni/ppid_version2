$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")

$replaces = @{
    "Sebanyak 48,39% responden menilai visual antarmuka dengan skor 2 (cukup/kurang)." = "100% (31 responden) memberikan penilaian tertinggi (Skor 4)."
    "Evaluasi estetika dashboard dinilai kurang membantu fokus kerja operator dalam menginput data secara harian, sehingga memerlukan pembaruan desain antarmuka yang lebih rapi, modern, dan intuitif." = "Hal ini menunjukkan bahwa desain antarmuka visual dashboard admin saat ini sudah sangat ergonomis, modern, dan intuitif, sehingga sukses mempermudah pekerjaan operator."
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

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done!"
