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

    if ($text -match "Optimalisasi website PPID Diskominfo Kabupaten Sinjai dilakukan untuk mengatasi kendala sistem sebelumnya dalam") {
        $text = "Optimalisasi website Pejabat Pengelola Informasi dan Dokumentasi (PPID) pada Dinas Komunikasi Informatika dan Persandian Kabupaten Sinjai dilakukan sebagai solusi strategis untuk mengatasi berbagai kendala teknis dari sistem sebelumnya, khususnya terkait kompleksitas penginputan data informasi publik oleh operator. Penelitian ini bertujuan untuk mengevaluasi tingkat ketergunaan (usability) dari website yang telah dioptimalkan tersebut berdasarkan persepsi admin Organisasi Perangkat Daerah (OPD). Evaluasi dilakukan dengan pendekatan kuantitatif deskriptif, mengacu pada standar metrik usability (ISO 9241-11), melalui penyebaran kuesioner kepada 31 responden yang mewakili berbagai instansi. Hasil analisis evaluasi menunjukkan tingkat keberhasilan yang sangat tinggi, dibuktikan dengan peningkatan produktivitas pelaporan (100% merasa lebih produktif) dan efisiensi pengkategorian dokumen (100% sangat terbantu). Selain itu, fitur penanganan kesalahan (error handling) dinilai sudah sangat jelas dan informatif (100% menjawab Ya), serta didukung oleh antarmuka visual (interface) yang dinilai sangat memuaskan (100%). Secara keseluruhan, sistem baru ini terbukti efektif dalam mempermudah beban kerja operator. Sebagai upaya perbaikan berkelanjutan, rekomendasi utama dari penelitian ini difokuskan pada pengembangan fitur pemantauan progres kelengkapan dokumen secara mandiri bagi para admin OPD.`n"
        $updated = $true
    }
    
    if ($text -match "The optimization of the Sinjai Regency Diskominfo PPID website was carried out to resolve previous system constraints") {
        $text = "The optimization of the Information and Documentation Management Officer (PPID) website at the Communication, Informatics, and Encoding Agency of Sinjai Regency was implemented as a strategic solution to overcome various technical constraints of the previous system, particularly regarding the complexity of public information data entry by operators. This study aims to evaluate the usability level of the optimized website based on the perceptions of Regional Apparatus Organization (OPD) admins. The evaluation was conducted using a descriptive quantitative approach, referring to standard usability metrics (ISO 9241-11), through the distribution of questionnaires to 31 respondents representing various agencies. The evaluation analysis results show a very high success rate, evidenced by increased reporting productivity (100% felt more productive) and document categorization efficiency (100% felt greatly assisted). Additionally, the error handling system was deemed highly clear and informative (100% answered Yes), supported by a visual interface that was rated as highly satisfactory (100%). Overall, the new system has proven to be effective in easing the workload of operators. For continuous improvement, the main recommendation of this study focuses on developing a self-monitoring feature for document completeness progress specifically designed for OPD admins.`n"
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
Write-Host "Done Lengthening Abstracts"
