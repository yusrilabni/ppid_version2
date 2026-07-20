$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")
$selection = $word.Selection

$selection.Find.ClearFormatting()
$selection.Find.Text = "96,43"
$result = $selection.Find.Execute()
Write-Host "Found 96,43: $result"

$selection.Find.ClearFormatting()
$selection.Find.Text = "28"
$result = $selection.Find.Execute()
Write-Host "Found 28: $result"

$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
