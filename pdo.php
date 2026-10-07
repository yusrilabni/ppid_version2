<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=ppidkab_version2', 'ppidkab_version2', '25T$tsrHXV6lec^l');
    $stmt = $pdo->query("SELECT slug, file FROM informasis WHERE slug LIKE '%laporan-kemajuan%' LIMIT 10");
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        echo 'SLUG: ' . $row['slug'] . ' FILE: ' . $row['file'] . "\n";
    }
} catch (Exception $e) { echo $e->getMessage(); }