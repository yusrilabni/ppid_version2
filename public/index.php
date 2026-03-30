<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Arahkan ke ppid_version2 di root home cPanel
require __DIR__.'/../../ppid_version2/vendor/autoload.php';
$app = require_once __DIR__.'/../../ppid_version2/bootstrap/app.php';

$app->handleRequest(Request::capture());
