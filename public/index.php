<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Cek Maintenance Mode
if (file_exists($maintenance = __DIR__.'/../../ppid_version2/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 2. Register Autoloader
require __DIR__.'/../../ppid_version2/vendor/autoload.php';

// 3. Bootstrap Laravel
$app = require_once __DIR__.'/../../ppid_version2/bootstrap/app.php';

// 4. Handle Request
$app->handleRequest(Request::capture());
