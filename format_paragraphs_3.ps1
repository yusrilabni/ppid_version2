$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

# Rewrite 4.3
for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    if ($text -match "^7\.Keberhasilan Sistem Pesan Kesalahan") {
        $p = $doc.Paragraphs.Item($i)
        $p.Range.Text = "Analisis terhadap hasil evaluasi menyoroti beberapa temuan kritis yang bernilai sangat positif, khususnya pada aspek penanganan kesalahan (error handling), desain antarmuka visual (UI/UX), dan peningkatan produktivitas kerja. Terkait keberhasilan sistem pesan kesalahan, seluruh responden (100%) menyatakan 'Ya' terhadap kejelasan pesan kesalahan yang dimunculkan sistem saat terjadi kekeliruan pengisian. Hal ini menunjukkan bahwa sistem telah sukses memberikan instruksi perbaikan yang sangat jelas ketika terjadi kegagalan validasi formulir, sehingga admin OPD merasa sangat terbantu dan tidak kebingungan saat memperbaiki kesalahan input data. Selanjutnya, pada aspek keberhasilan desain antarmuka visual, 100% responden memberikan penilaian tertinggi (Skor 4). Capaian ini mengonfirmasi bahwa desain antarmuka visual dashboard admin saat ini dinilai sudah sangat ergonomis, modern, dan intuitif, sehingga sukses mempermudah pekerjaan operator harian. Sisi positif lain yang sangat menonjol adalah adanya peningkatan produktivitas kerja, di mana 100% responden sepakat bahwa keberadaan website PPID hasil optimalisasi ini berhasil meningkatkan produktivitas pelaporan berkas publik mereka secara signifikan jika dibandingkan dengan sistem pengumpulan manual sebelumnya. Hal ini membuktikan pentingnya kelanjutan operasional aplikasi ini demi terwujudnya efisiensi birokrasi.`r`n"
        
        # Delete the next 5 paragraphs
        for ($j = 0; $j -lt 5; $j++) {
            $doc.Paragraphs.Item($i+1).Range.Delete()
        }
        break
    }
}

# Rewrite 4.5
for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    if ($text -match "Untuk meningkatkan usability sistem, responden mengajukan beberapa usulan fitur baru yang dirangkum sebagai berikut:") {
        $p = $doc.Paragraphs.Item($i)
        $p.Range.Text = "Untuk meningkatkan usability sistem secara berkesinambungan, para responden mengajukan beberapa usulan fitur baru. Usulan pertama yang paling banyak diharapkan adalah fitur pemantauan kelengkapan dokumen mandiri (self-monitoring progress). Melalui fitur ini, admin OPD mengharapkan adanya sebuah dasbor khusus untuk memantau status persentase kelengkapan dokumen instansi mereka sendiri secara langsung tanpa harus menunggu evaluasi manual dari PPID Utama Diskominfo. Usulan kedua adalah integrasi satu pintu, yakni terkoneksinya dasbor PPID secara langsung dengan website internal OPD masing-masing agar operator tidak perlu melakukan proses unggah dokumen yang sama sebanyak dua kali. Selain itu, pengembangan aplikasi PPID berbasis mobile (Android) juga sangat disarankan. Aplikasi smartphone dinilai jauh lebih praktis dan fleksibel bagi operator yang memiliki mobilitas tinggi, sehingga proses pelaporan tidak selalu bergantung pada ketersediaan komputer desktop di kantor. Terakhir, responden mengusulkan adanya sistem notifikasi pintar terintegrasi (push notification) untuk menyebarluaskan berita terbaru, pembaruan aturan, atau peringatan kelengkapan dokumen secara langsung ke dasbor para admin OPD guna meminimalisir ketergantungan pada koordinasi manual.`r`n"
        
        # Delete the next 8 paragraphs
        for ($j = 0; $j -lt 8; $j++) {
            $doc.Paragraphs.Item($i+1).Range.Delete()
        }
        break
    }
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done rewriting 4.3 and 4.5"
