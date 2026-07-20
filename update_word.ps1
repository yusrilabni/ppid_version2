$word = New-Object -ComObject Word.Application
$word.Visible = $false

$files = @(
    "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal_fix.docx",
    "C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx"
)

foreach ($path in $files) {
    if (Test-Path $path) {
        Write-Host "Processing $path"
        $doc = $word.Documents.Open($path)
        $selection = $word.Selection

        # Sequential replaces to be safe
        $replaces = @(
            @("93,55%", "100%"),
            @("29 (100%)", "31 (100%)"),
            @("29 dari 31", "31 dari 31"),
            @("5.1. Simpulan`r5.1. Simpulan", "5.1. Simpulan")
        )

        foreach ($r in $replaces) {
            $selection.Find.ClearFormatting()
            $selection.Find.Replacement.ClearFormatting()
            $selection.Find.Text = $r[0]
            $selection.Find.Replacement.Text = $r[1]
            $selection.Find.Wrap = 1 # wdFindContinue
            $selection.Find.Execute([ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, [ref]$null, 2)
        }
        
        # Add points 4 and 5 if they don't exist yet
        $selection.Find.ClearFormatting()
        $selection.Find.Text = "Pengembangan Aplikasi Mobile"
        if (-not $selection.Find.Execute()) {
            $selection.Find.ClearFormatting()
            $selection.Find.Text = "koneksi kembali stabil."
            if ($selection.Find.Execute()) {
                $selection.Collapse(0) # End of matched text
                $selection.TypeParagraph()
                $selection.TypeText("4. Pengembangan Aplikasi Mobile (Mobile App): Berdasarkan usulan operator, pengembangan aplikasi PPID berbasis mobile (Android) sangat disarankan. Aplikasi smartphone dinilai jauh lebih praktis dan fleksibel bagi operator yang mobilitasnya tinggi, sehingga proses pelaporan tidak harus bergantung pada ketersediaan komputer desktop di kantor.")
                $selection.TypeParagraph()
                $selection.TypeText("5. Sistem Notifikasi Pintar Terintegrasi: Pembuatan modul pemberitahuan (push notification) untuk menyebarluaskan berita terbaru, pembaruan aturan, atau peringatan kelengkapan dokumen secara langsung ke dashboard (atau aplikasi mobile) para admin OPD. Hal ini akan mengurangi ketergantungan pada koordinasi manual.")
            }
        }
        
        $doc.Save()
        $doc.Close()
    }
}

$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done"
