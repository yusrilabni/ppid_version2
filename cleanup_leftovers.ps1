$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    $shouldDelete = $false
    if ($text -match "Menengah \(Paham web & aplikasi\): 61,29% \(19 orang\)") { $shouldDelete = $true }
    if ($text -match "Pemula: 38,71% \(12 orang\)") { $shouldDelete = $true }
    if ($text -match "Analisis: Lebih dari sepertiga pengguna menganggap diri mereka pemula dalam teknologi") { $shouldDelete = $true }

    if ($shouldDelete) {
        $doc.Paragraphs.Item($i).Range.Delete()
        $i-- # Adjust index
    }
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done cleanup"
