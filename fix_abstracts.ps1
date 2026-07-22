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

Replace-Text "Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%). Rekomendasi utama mencakup perbaikan pesan kesalahan dan pengembangan fitur pemantauan progres dokumen mandiri bagi admin OPD." "Selain itu, penanganan kesalahan (error handling) dinilai sudah sangat informatif (100% menjawab Ya). Rekomendasi utama berfokus pada pengembangan fitur pemantauan progres dokumen mandiri bagi admin OPD."

Replace-Text "However, error handling was deemed uninformative (100%). The main recommendations include improving error messages and adding a self-monitoring feature for document progress for OPD admins." "Additionally, the error handling system was deemed highly informative (100% Yes). The main recommendations focus on adding a self-monitoring feature for document progress for OPD admins."

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
