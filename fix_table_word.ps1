$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")

try {
    $table = $doc.Tables.Item(1)
    $table.Cell(10, 2).Range.Text = "Kemudahan visual antarmuka dashboard admin"
    $table.Cell(10, 3).Range.Text = "0,00%"
    $table.Cell(10, 4).Range.Text = "0,00%"
    $table.Cell(10, 5).Range.Text = "0,00%"
    $table.Cell(10, 6).Range.Text = "31 (100%)"
    $table.Cell(10, 7).Range.Text = "Sangat Baik (100% menilai sangat baik)"
} catch {
    Write-Host "Error: $_"
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Table fixed!"
