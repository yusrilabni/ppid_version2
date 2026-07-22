$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

$count = $doc.Paragraphs.Count
for ($i = 1; $i -le 30; $i++) {
    $para = $doc.Paragraphs.Item($i)
    $text = $para.Range.Text
    $updated = $false

    if ($text -match "Optimalisasi website Pejabat Pengelola Informasi dan Dokumentasi") {
        $text = "Optimalisasi website PPID Diskominfo Kabupaten Sinjai bertujuan mengatasi kendala teknis dalam pelaporan informasi publik. Penelitian ini mengevaluasi tingkat usability website berdasarkan persepsi admin Organisasi Perangkat Daerah (OPD) menggunakan standar ISO 9241-11. Melalui kuesioner kepada 31 responden, hasil evaluasi menunjukkan tingkat keberhasilan yang sangat tinggi. Sistem baru sukses meningkatkan produktivitas pelaporan (100%) dan efisiensi pengkategorian (100%), didukung oleh antarmuka visual yang memuaskan (100%). Fitur penanganan kesalahan (error handling) juga terbukti sangat jelas dan informatif (100% menjawab Ya). Secara keseluruhan, sistem sangat mempermudah pekerjaan operator. Rekomendasi utama difokuskan pada pengembangan fitur pemantauan progres kelengkapan dokumen secara mandiri bagi admin OPD.`n"
        $updated = $true
    }
    
    if ($text -match "The optimization of the Information and Documentation Management") {
        $text = "The optimization of the Sinjai Regency Diskominfo PPID website aims to overcome technical constraints in public information reporting. This study evaluates the website's usability based on the perceptions of Regional Apparatus Organization (OPD) admins using the ISO 9241-11 standard. Through a questionnaire given to 31 respondents, the evaluation results show a very high success rate. The new system successfully increased reporting productivity (100%) and categorization efficiency (100%), supported by a highly satisfactory visual interface (100%). The error handling feature also proved to be very clear and informative (100% Yes). Overall, the system greatly facilitates the operators' work. The main recommendation focuses on developing a self-monitoring feature for document completeness progress for OPD admins.`n"
        $updated = $true
    }

    if ($updated) {
        $para.Range.Text = $text
    }
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done Medium Abstracts"
