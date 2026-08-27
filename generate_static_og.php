<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";

$logoPath = public_path("storage/logo/Lambang_Kabupaten_Sinjai.png");
if (!file_exists($logoPath)) {
    die("Logo not found at $logoPath");
}

$logo = imagecreatefromstring(file_get_contents($logoPath));
$logoW = imagesx($logo);
$logoH = imagesy($logo);

$canvasW = 1200;
$canvasH = 630;

$canvas = imagecreatetruecolor($canvasW, $canvasH);
$white = imagecolorallocate($canvas, 255, 255, 255);
imagefill($canvas, 0, 0, $white);

$padding = 50;
$targetH = $canvasH - ($padding * 2);
$scale = $targetH / $logoH;
$targetW = $logoW * $scale;

$dstX = ($canvasW - $targetW) / 2;
$dstY = $padding;

imagecopyresampled($canvas, $logo, $dstX, $dstY, 0, 0, $targetW, $targetH, $logoW, $logoH);

// Save as highly optimized JPG
$outputPath = public_path("storage/logo/Lambang_Kabupaten_Sinjai_OG.jpg");
imagejpeg($canvas, $outputPath, 85);

imagedestroy($canvas);
imagedestroy($logo);

echo "Created: $outputPath";

