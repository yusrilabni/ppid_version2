$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

foreach ($para in $doc.Paragraphs) {
    if ($para.Range.Text -match "Rekomendasi utama mencakup perbaikan pesan kesalahan, fitur pemantauan progres dokumen mandiri, dan dukungan unggah luring") {
        $text = $para.Range.Text
        $text = $text.Replace(", fitur pemantauan progres dokumen mandiri, dan dukungan unggah luring (offline upload) untuk mengatasi masalah kestabilan jaringan internet.", " dan pengembangan fitur pemantauan progres dokumen mandiri bagi admin OPD.")
        $para.Range.Text = $text
    }
    if ($para.Range.Text -match "The main recommendations include improving error messages, adding a self-monitoring feature for document progress, and developing an offline upload feature") {
        $text = $para.Range.Text
        $text = $text.Replace(", adding a self-monitoring feature for document progress, and developing an offline upload feature to address internet connection stability constraints.", " and adding a self-monitoring feature for document progress for OPD admins.")
        $para.Range.Text = $text
    }
}

$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "Offline Mode Upload"
if ($selection.Find.Execute()) {
    $para = $selection.Paragraphs.Item(1)
    $nextPara = $para.Next()
    $para.Range.Delete()
    if ($nextPara -and $nextPara.Range.Text.Contains("luring")) {
        $nextPara.Range.Delete()
    }
}

$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "Upload Caching"
if ($selection.Find.Execute()) {
    $para = $selection.Paragraphs.Item(1)
    $para.Range.Delete()
}

$doc.Save()
Write-Host "Success Update"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
