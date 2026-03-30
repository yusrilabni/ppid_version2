<?php
// Diagnostik Error
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Arahkan ke ppid_version2 di root home
require __DIR__.'/../../ppid_version2/vendor/autoload.php';
$app = require_once __DIR__.'/../../ppid_version2/bootstrap/app.php';

$app->handleRequest(Request::capture());
