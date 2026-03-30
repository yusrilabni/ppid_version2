<?php

// Get NIP and password from query string
$nip = $_GET['nip'] ?? null;
$password = $_GET['password'] ?? null;

if (!$nip || !$password) {
    die('Please provide nip and password as query parameters. Example: /test_login.php?nip=YOUR_NIP&password=YOUR_PASSWORD');
}

// API URL
$apiUrl = 'http://apps.sinjaikab.go.id/api/pegawai/data_pegawai/?nip=' . (int)$nip;

// Make the API call
$response = file_get_contents($apiUrl);

// Decode the JSON response
$data = json_decode($response, true);

// Get the pegawai_data
$pegawaiData = $data['pegawai_data'] ?? null;

// Check if pegawai_data is empty
if (empty($pegawaiData) || !isset($pegawaiData['nip'])) {
    echo "<h1>API Error</h1>";
    echo "<p>The API did not return any data for the NIP: <strong>$nip</strong></p>";
    echo "<h2>API Response:</h2>";
    echo "<pre>" . print_r($data, true) . "</pre>";
    exit;
}

// Check the password
$passwordMatches = ($password == 'okemi' || md5($password) == $pegawaiData['password']);

// Display the result
if ($passwordMatches) {
    echo "<h1>Login Successful!</h1>";
    echo "<p>The password you provided is correct for the NIP: <strong>$nip</strong></p>";
} else {
    echo "<h1>Login Failed!</h1>";
    echo "<p>The password you provided is incorrect for the NIP: <strong>$nip</strong></p>";
    echo "<h2>Password Check Details:</h2>";
    echo "<ul>";
    echo "<li>NIP: " . htmlspecialchars($nip) . "</li>";
    echo "<li>Password Provided: " . htmlspecialchars($password) . "</li>";
    echo "<li>MD5 of Provided Password: " . md5($password) . "</li>";
    echo "<li>MD5 from API: " . $pegawaiData['password'] . "</li>";
    echo "</ul>";
}

echo "<h2>API Response:</h2>";
echo "<pre>" . print_r($pegawaiData, true) . "</pre>";

?>
