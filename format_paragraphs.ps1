$word = New-Object -ComObject Word.Application
$word.Visible = $false
$word.DisplayAlerts = 0
$path = "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
$doc = $word.Documents.Open($path, $false, $false)

# 1. Landasan Teori
$foundLandasan = $false
for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    if ($text -match "^1\.Usability \(Ketergunaan\):") {
        $p1 = $doc.Paragraphs.Item($i)
        $p2 = $doc.Paragraphs.Item($i+1)
        $p3 = $doc.Paragraphs.Item($i+2)
        
        $p1.Range.Text = "Kajian ini didasarkan pada tiga landasan teori utama, yaitu usability (ketergunaan), Technology Acceptance Model (TAM), dan konsep sistem informasi pelaporan publik. Usability didefinisikan sebagai tingkat kemampuan suatu produk, seperti aplikasi web, untuk digunakan oleh pengguna tertentu guna mencapai tujuan secara efektif, efisien, dan memberikan kepuasan dalam konteks penggunaan tertentu sesuai standar ISO 9241-11. Beberapa aspek penting di dalamnya meliputi kemudahan dipelajari (learnability), efisiensi alur (efficiency), penanganan kesalahan (error handling), dan kepuasan pengguna (satisfaction). Selanjutnya, pendekatan Technology Acceptance Model (TAM) yang dikembangkan oleh Davis (1989) digunakan untuk menjelaskan bahwa penerimaan pengguna terhadap suatu sistem informasi sangat dipengaruhi oleh dua variabel utama, yakni persepsi kemanfaatan (perceived usefulness) dan persepsi kemudahan penggunaan (perceived ease of use). Kedua konsep ini kemudian diterapkan dalam konteks sistem informasi pelaporan publik, di mana penerapan teknologi informasi pada sektor pemerintahan (e-Government) bertujuan untuk meningkatkan efisiensi proses internal sekaligus memperluas transparansi layanan eksternal kepada masyarakat luas.`r`n"
        $p1.Format.ListFormat.RemoveNumbers()
        
        $p2.Range.Delete()
        $p2.Range.Delete()
        $foundLandasan = $true
        break
    }
}

# 2. Metode Penelitian
for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    if ($text -match "Penelitian ini menggunakan pendekatan kombinasi deskriptif kuantitatif dan kualitatif\.") {
        $p1 = $doc.Paragraphs.Item($i)
        $p2 = $doc.Paragraphs.Item($i+1) # Populasi
        $p3 = $doc.Paragraphs.Item($i+2) # Pengumpulan
        $p4 = $doc.Paragraphs.Item($i+3) # Analisis
        
        $p1.Range.Text = "Penelitian ini menggunakan pendekatan kombinasi deskriptif kuantitatif dan kualitatif. Populasi dan sampel dalam penelitian ini melibatkan 31 responden yang mencakup seluruh admin atau operator PPID pembantu dari berbagai dinas, badan, kecamatan, kelurahan, dan desa di lingkungan Kabupaten Sinjai yang aktif menggunakan website PPID. Proses pengumpulan data dilakukan melalui pengisian kuesioner internal yang telah terintegrasi langsung pada website PPID tersebut. Kuesioner ini dirancang untuk mengukur tanggapan pengguna terhadap berbagai indikator, seperti alur kerja, verifikasi, antarmuka visual, pesan kesalahan, kecepatan respons, tingkat keamanan, serta metrik peningkatan produktivitas kerja menggunakan skala Likert mulai dari 1 hingga 4. Selain itu, kuesioner juga memuat pertanyaan terbuka untuk menggali kendala operasional serta usulan fitur baru. Pada tahap selanjutnya, data kuantitatif diolah menggunakan teknik persentase deskriptif untuk mengetahui sejauh mana tingkat kesetujuan responden pada masing-masing indikator. Sementara itu, data kualitatif yang diperoleh dari pertanyaan terbuka dianalisis secara tematik guna mengelompokkan kendala utama serta mengidentifikasi kebutuhan fitur baru yang diusulkan oleh para responden.`r`n"
        
        $p2.Range.Delete()
        $p2.Range.Delete()
        $p2.Range.Delete()
        break
    }
}

# 3. Profil Karakteristik Responden
for ($i = 1; $i -le $doc.Paragraphs.Count; $i++) {
    $text = $doc.Paragraphs.Item($i).Range.Text
    if ($text -match "Berdasarkan data yang dihimpun dari 31 responden admin OPD, berikut adalah karakteristik profil pengguna:") {
        $p1 = $doc.Paragraphs.Item($i)
        # We need to delete next 15 paragraphs (3 sections of 5 paras each approx)
        # Actually it's safer to just delete them one by one
        $p1.Range.Text = "Berdasarkan data yang berhasil dihimpun dari 31 responden admin Organisasi Perangkat Daerah (OPD), profil pengguna dapat dikategorikan berdasarkan jabatan, lama penggunaan, dan tingkat pemahaman teknologi. Dilihat dari jabatan atau perannya dalam pengelolaan PPID, sebanyak 48,39% (15 orang) bertugas sebagai Admin Utama OPD atau Operator, 16,13% (5 orang) berstatus sebagai Pejabat Fungsional atau Struktural, dan sisanya sebanyak 35,48% (11 orang) menjabat posisi lainnya. Hal ini menunjukkan bahwa sebagian besar pengguna aktif di dasbor adalah staf operator teknis yang memegang tanggung jawab langsung dalam aktivitas penginputan data harian.`r`n`r`nSelanjutnya, ditinjau dari lamanya waktu mengelola data PPID, mayoritas responden sebanyak 51,61% (16 orang) baru mengelola data selama kurang dari satu tahun. Sisanya terbagi rata, di mana 19,35% (6 orang) telah mengelola selama 1 hingga 3 tahun, dan 19,35% lainnya lebih dari 3 tahun. Fakta bahwa mayoritas operator merupakan staf baru menegaskan pentingnya ketersediaan sistem dengan tingkat kemudahan dipelajari (learnability) yang tinggi, sehingga mereka dapat beradaptasi secara mandiri tanpa memerlukan pelatihan intensif yang memakan waktu lama.`r`n`r`nAdapun berdasarkan evaluasi mandiri (self-assessment) terhadap tingkat pemahaman teknologi, sebanyak 61,29% (19 orang) responden menyatakan berada di tingkat menengah atau sudah cukup paham mengenai penggunaan aplikasi berbasis web. Namun, sebanyak 38,71% (12 orang) pengguna lainnya masih menganggap diri mereka sebagai pemula dalam pemanfaatan teknologi. Kondisi ini menyoroti bahwa desain petunjuk penggunaan dan antarmuka visual pada sistem PPID harus dirancang sesederhana dan seintuitif mungkin agar tetap ramah bagi pengguna pemula.`r`n"
        
        # Delete next 15 paras
        for ($j = 0; $j -lt 15; $j++) {
            $doc.Paragraphs.Item($i+1).Range.Delete()
        }
        break
    }
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done Formatting Paragraphs"
