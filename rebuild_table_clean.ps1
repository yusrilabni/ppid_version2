$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0

$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")

$tableData = @(
    @("1", "Kemudahan melakukan pengunggahan dokumen informasi publik", "12,90%", "16,13%", "51,61%", "19,35%", "Cukup Baik (70,97% setuju)"),
    @("2", "Kemudahan pengelompokan dokumen otomatis (kategori Berkala/Serta-merta/Setiap Saat)", "0,00%", "0,00%", "61,29%", "38,71%", "Sangat Baik (100% setuju)"),
    @("3", "Keakuratan fitur verifikasi dalam mendeteksi kelengkapan dokumen", "0,00%", "19,35%", "48,39%", "32,26%", "Baik (80,65% setuju)"),
    @("4", "Keringkasan alur kerja (workflow) dari login hingga publikasi", "0,00%", "25,81%", "45,16%", "29,03%", "Baik (74,19% setuju)"),
    @("5", "Kecepatan respons (loading speed) saat mengunggah file/link", "0,00%", "29,03%", "41,94%", "29,03%", "Cukup Baik (70,97% setuju)"),
    @("6", "Kemudahan pengelolaan (edit/hapus) data terpublikasi", "0,00%", "25,81%", "48,39%", "25,81%", "Baik (74,19% setuju)"),
    @("7", "Kemudahan memahami menu dan label instruksi di dashboard", "6,45%", "29,03%", "41,94%", "22,58%", "Cukup (64,52% setuju)"),
    @("8", "Kejelasan pesan kesalahan (error message) ketika terjadi kegagalan input", "100%", "0,00%", "0,00%", "0,00%", "Sangat Kurang (100% menilai tidak jelas)"),
    @("9", "Kemudahan visual antarmuka dashboard admin", "0,00%", "0,00%", "0,00%", "31 (100%)", "Sangat Baik (100% setuju)"),
    @("10", "Tingkat rasa aman penyimpanan dokumen instansi di website", "0,00%", "38,71%", "32,26%", "29,03%", "Cukup (61,29% merasa aman)"),
    @("11", "Peningkatan produktivitas dibanding sistem lama", "0,00%", "0,00%", "0,00%", "31 (100%)", "Sangat Baik (100% merasa produktif)")
)

try {
    $table = $doc.Tables.Item(1)
    for ($i = 0; $i -lt $tableData.Length; $i++) {
        $row = $i + 2
        for ($col = 0; $col -lt 7; $col++) {
            $table.Cell($row, ($col + 1)).Range.Text = $tableData[$i][$col]
        }
    }
} catch {
    Write-Host "Error: $_"
}

$doc.Save()
$doc.Close(0)
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Table completely rebuilt successfully!"
