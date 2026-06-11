<?php
// Script untuk mengetes apakah Webhook Laravel bisa menerima data POST
$url = 'https://ppidkab.sinjaikab.go.id/v2/api/whatsapp/webhook';
$data = [
    'from' => 'nomor_test_manual@c.us',
    'body' => '#status'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

echo "<h3>Hasil Pengetesan Webhook Manual</h3>";
echo "URL Tujuan: " . $url . "<br>";
echo "HTTP Code: " . $info['http_code'] . "<br>";
echo "Respon Server: " . $response . "<br><br>";
echo "<b>Jika HTTP Code adalah 200, silakan cek kembali halaman <a href='/v2/wa-debug-view'>wa-debug-view</a></b>";
