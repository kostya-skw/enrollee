Enrollee
===============================

Система для заполнения он-лайн анкеты в приемную комиссию образовательного учрежения.
В стадии разработки. Версия далеко до релиза.

Для связи с разработчиком используйте почту kostya.skw@gmail.com



Apache Configuration
---
```
<VirtualHost *:80>
    ServerName site.name
    #ErrorLog /dev/null
    #LogLevel emerg
    #CustomLog /dev/null combined

    RewriteEngine on
    # the main rewrite rule for the frontend application
    RewriteCond %{REQUEST_URI} !^/(backend/web|admin)
    RewriteRule !^/frontend/web /frontend/web%{REQUEST_URI} [L]
    # redirect to the page without a trailing slash (uncomment if necessary)
    #RewriteCond %{REQUEST_URI} ^/admin/$
    #RewriteRule ^(/admin)/ $1 [L,R=301]
    # disable the trailing slash redirect
    RewriteCond %{REQUEST_URI} ^/admin$
    RewriteRule ^/admin /backend/web/index.php [L]
    # the main rewrite rule for the backend application
    RewriteCond %{REQUEST_URI} ^/admin
    RewriteRule ^/admin(.*) /backend/web$1 [L]

    DocumentRoot /path/to/rootdir
    <Directory />
        Options FollowSymLinks
        AllowOverride None
        AddDefaultCharset utf-8
    </Directory>
    <Directory /path/to/rootdir/frontend/web>
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Order Allow,Deny
        Allow from all
    </Directory>
    <Directory /path/to/rootdir/backend/web/>
        RewriteEngine on
        # if a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # otherwise forward the request to index.php
        RewriteRule . index.php

        Order Allow,Deny
        Allow from all
    </Directory>
    <FilesMatch \.(htaccess|htpasswd|svn|git)>
        Deny from all
        Satisfy All
    </FilesMatch>
</VirtualHost>
```

Nginx Configuration
---
```
server {
    listen       80; # listen for IPv4
    #listen       [::]:80 ipv6only=on; # listen for IPv6
    server_name  site.name;
    root         /path/to/rootdir;

    #access_log   off;
    #error_log    /dev/null crit;
    charset      utf-8;
    client_max_body_size  100M;

    location / {
        root  /path/to/rootdir/frontend/web;
        try_files  $uri /frontend/web/index.php?$args;
    }

    location ~* \.php$ {
        try_files  $uri /frontend/web$uri =404;
        # check the www.conf file to see if PHP-FPM is listening on a socket or a port
        fastcgi_pass  unix:/run/php-fpm/php-fpm.sock; # listen for socket
        #fastcgi_pass  127.0.0.1:9000; # listen for port
        include  /etc/nginx/fastcgi_params;
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    # avoid processing of calls to non-existing static files by Yii (uncomment if necessary)
    #location ~* \.(css|js|jpg|jpeg|png|gif|bmp|ico|mov|swf|pdf|zip|rar)$ {
    #    access_log  off;
    #    log_not_found  off;
    #    try_files  $uri /frontend/web$uri =404;
    #}

    location ~* \.(htaccess|htpasswd|svn|git) {
        deny all;
    }

    location /admin {
        alias  /path/to/rootdir/backend/web;
        try_files  $uri /backend/web/index.php?$args;

        # redirect to the page without a trailing slash (uncomment if necessary)
        #location = /admin/ {
        #    return  301 /admin;
        #}

        location ~* ^/admin/(.+\.php)$ {
            try_files  $uri /backend/web/$1?$args;
        }

        # avoid processing of calls to non-existing static files by Yii (uncomment if necessary)
        #location ~* ^/admin/(.+\.(css|js|jpg|jpeg|png|gif|bmp|ico|mov|swf|pdf|zip|rar))$ {
        #    try_files  $uri /backend/web/$1?$args;
        #}
    }
}
```