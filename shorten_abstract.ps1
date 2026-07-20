$word = New-Object -ComObject Word.Application
$word.Visible = $false
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path)

foreach ($para in $doc.Paragraphs) {
    if ($para.Range.Text -like "Keterbukaan informasi publik merupakan pilar utama*") {
        $para.Range.Text = "Optimalisasi website PPID Diskominfo Kabupaten Sinjai dilakukan untuk mengatasi kendala sistem sebelumnya dalam penginputan data informasi publik. Penelitian ini mengevaluasi usability website tersebut berdasarkan persepsi admin Organisasi Perangkat Daerah (OPD) melalui penyebaran kuesioner kepada 31 responden. Hasilnya menunjukkan peningkatan produktivitas pelaporan (100%) dan efisiensi pengkategorian (100%), didukung antarmuka visual yang sangat memuaskan (100%). Namun, penanganan kesalahan (error handling) dinilai belum informatif (100%). Rekomendasi utama mencakup perbaikan pesan kesalahan, fitur pemantauan progres dokumen mandiri, dan dukungan unggah luring (offline upload) untuk mengatasi masalah kestabilan jaringan internet.`n"
    }
    if ($para.Range.Text -like "Public information disclosure is a key pillar*") {
        $para.Range.Text = "The optimization of the Sinjai Regency Diskominfo PPID website was carried out to resolve previous system constraints in public information reporting. This study evaluates its usability based on the perception of regional agency (OPD) admins by distributing questionnaires to 31 respondents. Results show increased reporting productivity (100%) and efficient categorization (100%), supported by a highly satisfactory interface (100%). However, error handling was deemed uninformative (100%). The main recommendations include improving error messages, adding a self-monitoring feature for document progress, and developing an offline upload feature to address internet connection stability constraints.`n"
    }
}

$doc.Save()
Write-Host "Abstract shortened successfully!"
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
