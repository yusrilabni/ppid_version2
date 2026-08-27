<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create("/transparansi/informasi-pemkab", "GET");
$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo substr($response->getContent(), 0, 500);

