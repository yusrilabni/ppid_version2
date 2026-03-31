<?php
/**
 * Simple Auto-Deploy Script for GitHub Webhooks
 */

// Ganti dengan token rahasia Anda (bebas tapi harus sama dengan di GitHub)
$secret = 'ppid_secret_deploy_token';
$path = '/home/ppidkab/ppid_version2'; // Sesuaikan dengan path folder aplikasi Anda di server

// Log file
$logFile = 'deploy.log';

// Get headers
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';

if (!$signature) {
    die('No signature');
}

// Verify signature
$payload = file_get_contents('php://input');
list($algo, $hash) = explode('=', $signature, 2);
$payloadHash = hash_hmac($algo, $payload, $secret);

if ($hash !== $payloadHash) {
    die('Invalid signature');
}

// Execute deployment
$output = [];
$returnVar = 0;

// Jalankan git pull
// Pastikan user ppidkab punya akses ke folder tersebut
chdir($path);
exec("git pull origin main 2>&1", $output, $returnVar);

// Catat ke log
$logData = date('[Y-m-d H:i:s]') . " Result: " . ($returnVar === 0 ? 'Success' : 'Failed') . "\n";
$logData .= implode("\n", $output) . "\n\n";
file_put_contents($logFile, $logData, FILE_APPEND);

echo "Deployment finished with status: " . ($returnVar === 0 ? 'Success' : 'Failed');
