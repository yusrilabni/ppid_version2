$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")
$text = $doc.Content.Text
$text | Out-File -FilePath "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal_full_text.txt" -Encoding utf8
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
