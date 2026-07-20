$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal_fix.docx")
$text = $doc.Content.Text
Write-Host $text.Substring(0, [math]::Min($text.Length, 1500))
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
