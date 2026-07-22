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

    if ($text -match "Namun, penanganan kesalahan \(error handling\) dinilai belum informatif") {
        $text = $text.Replace("Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%). Rekomendasi utama mencakup perbaikan pesan kesalahan dan pengembangan fitur pemantauan progres dokumen mandiri bagi admin OPD.", "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif (100% menjawab Ya). Rekomendasi utama berfokus pada pengembangan fitur pemantauan progres dokumen mandiri bagi admin OPD.")
        $updated = $true
    }
    if ($text -match "However, error handling was deemed uninformative") {
        $text = $text.Replace("However, error handling was deemed uninformative (100%). The main recommendations include improving error messages and adding a self-monitoring feature for document progress for OPD admins.", "Additionally, the error handling system was deemed highly informative (100% Yes). The main recommendations focus on adding a self-monitoring feature for document progress for OPD admins.")
        $updated = $true
    }

    if ($updated) {
        $para.Range.Text = $text
    }
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done Fixing Abstracts"
