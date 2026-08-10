<?php
putenv("MYSQL_ATTR_SSL_CA=C:\\laragon\\etc\\ssl\\cacert.pem");
$_ENV['MYSQL_ATTR_SSL_CA'] = "C:\\laragon\\etc\\ssl\\cacert.pem";

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $orgs = App\Models\Organization::pluck('name')->toArray();
    foreach ($orgs as $o) {
        if (stripos($o, 'desa') !== false || stripos($o, 'kelurahan') !== false) {
            echo "Match: " . $o . PHP_EOL;
        }
    }
} catch (\Exception $e) {
    echo "DB Error: " . $e->getMessage() . PHP_EOL;
}
