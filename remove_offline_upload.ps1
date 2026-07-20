$word = New-Object -ComObject Word.Application
$word.Visible = $false
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path)
$missing = [System.Reflection.Missing]::Value

# 1. & 2. Update Abstracts
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

# 3. Remove "Fitur Sinkronisasi Luring" from 4.5 (or "Usulan Pengembangan Mekanisme Cache Penyimpanan Sementara (Offline Mode Upload)" depending on exact text)
# In section 4.5, the text was likely "Fitur Sinkronisasi Luring (Offline Mode / Buffer Upload):" or similar.
$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "Fitur Sinkronisasi Luring"
if ($selection.Find.Execute()) {
    $para = $selection.Paragraphs.Item(1)
    $nextPara = $para.Next()
    $para.Range.Delete()
    if ($nextPara) {
        $nextPara.Range.Delete()
    }
} else {
    $selection.HomeKey(6) | Out-Null
    $selection.Find.Text = "Offline Mode Upload"
    if ($selection.Find.Execute()) {
        $para = $selection.Paragraphs.Item(1)
        $nextPara = $para.Next()
        $para.Range.Delete()
        if ($nextPara -and ($nextPara.Range.Text -match "luring|sinkronisasi")) {
            $nextPara.Range.Delete()
        }
    }
}

# 4. Remove "Fitur Upload Caching" from 5.2
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Text = "Fitur Upload Caching"
if ($selection.Find.Execute()) {
    $selection.Paragraphs.Item(1).Range.Delete()
}

$doc.Save()
Write-Host "Offline upload references removed successfully!"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
