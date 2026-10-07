<?php
require __DIR__.'/vendor/autoload.php';
\ = require_once __DIR__.'/bootstrap/app.php';
\ = \->make(Illuminate\Contracts\Console\Kernel::class);
\->bootstrap();

\ = 0;

\ = function(\, \) use (&\) {
    \ = \::all();
    foreach (\ as \) {
        foreach (\ as \) {
            \ = strtolower(\->{\} ?? '');
            if (strpos(\, '<script') !== false || strpos(\, '<iframe') !== false || strpos(\, 'eval(') !== false) {
                echo \"Suspicious payload found in \" . class_basename(\) . \" ID {\->id} Column {\}\n\";
                \++;
            }
        }
    }
};

\(\App\Models\Berita::class, ['title', 'content']);
\(\App\Models\Informasi::class, ['title', 'content', 'deskripsi']);

if (\ == 0) echo \"Database scan clean! No suspicious payloads found.\n\";