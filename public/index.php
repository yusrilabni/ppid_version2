<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path absolut yang sudah terbukti jalan di tes tadi
$basePath = '/home/ppidkab/ppid_version2';

// 1. Register Autoloader
require $basePath . '/vendor/autoload.php';

// 2. Bootstrap Laravel
$app = require_once $basePath . '/bootstrap/app.php';

// 3. Handle Request
$app->handleRequest(Request::capture());
