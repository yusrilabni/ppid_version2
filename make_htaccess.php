<?php
\ = \"<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^robots\.txt$ /web/robots.txt [L]
    RewriteCond %{REQUEST_URI} ^/v2/(.*)$
    RewriteRule ^(.*)$ https://ppid.sinjaikab.go.id/%1 [R=301,L]
    RewriteRule ^$ https://ppid.sinjaikab.go.id/ [R=301,L]
    RewriteCond %{REQUEST_URI} ^/api/ [OR]
    RewriteCond %{REQUEST_URI} ^/storage/ [OR]
    RewriteCond %{REQUEST_URI} ^/sanctum/ [OR]
    RewriteCond %{REQUEST_URI} ^/livewire/ [OR]
    RewriteCond %{REQUEST_URI} ^/media/ [OR]
    RewriteCond %{REQUEST_URI} ^/assets/ [OR]
    RewriteCond %{REQUEST_URI} ^/build/ [OR]
    RewriteCond %{REQUEST_URI} ^/vendor/
    RewriteRule ^(.*)$ /web/\ [L]
    RewriteCond %{REQUEST_URI} ^/web(/.*)?$
    RewriteRule ^ - [L]
    RewriteRule ^(.*)$ https://ppid.sinjaikab.go.id/\ [R=301,L]
</IfModule>\";
file_put_contents('/home/ppidkab/public_html/.htaccess', \);
