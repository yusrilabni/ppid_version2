$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)
$missing = [System.Reflection.Missing]::Value

# 1. Indonesian Abstract
$selection = $word.Selection
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Replacement.ClearFormatting()
$selection.Find.Text = ", dan dukungan unggah luring (offline upload) untuk mengatasi masalah kestabilan jaringan internet."
$selection.Find.Replacement.Text = " bagi admin OPD."
$selection.Find.Execute([ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]1, [ref]$missing, [ref]$missing, [ref]2) | Out-Null

# 2. English Abstract
$selection.HomeKey(6) | Out-Null
$selection.Find.ClearFormatting()
$selection.Find.Replacement.ClearFormatting()
$selection.Find.Text = ", and developing an offline upload feature to address internet connection stability constraints."
$selection.Find.Replacement.Text = " for OPD admins."
$selection.Find.Execute([ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]$missing, [ref]1, [ref]$missing, [ref]$missing, [ref]2) | Out-Null

# 3. Section 4.5
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

# 4. Section 5.2
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
