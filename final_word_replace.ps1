$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("C:\laragon\www\PPID\ppid-laravel\production_deployment\ppid_version2\jurnal.docx")

$replaces = @{
    "28 responden" = "31 responden"
    "96,43% responden" = "100% responden"
    "50% menilai cukup/kurang" = "48,39% menilai cukup/kurang"
    "to 28 respondents" = "to 31 respondents"
    "96.43% of respondents" = "100% of respondents"
    "50% rated as average/poor" = "48.39% rated as average/poor"
    "28 orang yang merupakan" = "31 orang yang merupakan"
    "dari 28 responden admin" = "dari 31 responden admin"
    "50,00% (14 orang)" = "48,39% (15 orang)"
    "17,86% (5 orang)" = "16,13% (5 orang)"
    "32,14% (9 orang)" = "35,48% (11 orang)"
    "57,14% (16 orang)" = "51,61% (16 orang)"
    "21,43% (6 orang)" = "19,35% (6 orang)"
    "64,29% (18 orang)" = "61,29% (19 orang)"
    "35,71% (10 orang)" = "38,71% (12 orang)"
    "96,43% menilai tidak jelas" = "100% menilai tidak jelas"
    "50% menilai skor 2" = "48,39% menilai skor 2"
    "Sebanyak 96,43% responden" = "Sebanyak 100% responden"
    "Sebanyak 50,00% responden" = "Sebanyak 48,39% responden"
    "96,43% tidak setuju" = "100% tidak setuju"
    "50% respon netral/negatif" = "48,39% respon netral/negatif"
}

foreach ($key in $replaces.Keys) {
    $selection = $word.Selection
    $selection.HomeKey(6) | Out-Null
    $selection.Find.ClearFormatting()
    $selection.Find.Replacement.ClearFormatting()
    $selection.Find.Text = $key
    $selection.Find.Replacement.Text = $replaces[$key]
    $selection.Find.Forward = $true
    $selection.Find.Wrap = 1
    $selection.Find.Format = $false
    $selection.Find.MatchCase = $false
    $selection.Find.MatchWholeWord = $false
    $selection.Find.MatchWildcards = $false
    $selection.Find.MatchSoundsLike = $false
    $selection.Find.MatchAllWordForms = $false
    $selection.Find.Execute([System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, [System.Reflection.Missing]::Value, 2) | Out-Null
}

$doc.Save()
$doc.Close()
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null
Write-Host "Done!"
