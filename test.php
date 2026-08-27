<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::create("/share/og-image/logo", "GET");
$response = $kernel->handle($request);
echo strlen($response->getContent());

