#!/bin/bash
if [ -z "$1" ]
  then
    die "No argument supplied";
fi


echo "<VirtualHost *:80>
  ServerName www.$1
  ServerAlias $1
  DocumentRoot /var/www/$1
  DirectoryIndex index.php index.html
  ErrorLog  /var/www/$1.error.log
  UseCanonicalName On
<Directory \"/var/www/$1/\">
Options FollowSymLinks
AllowOverride All
</Directory>
</VirtualHost> " > /etc/apache2/sites-available/$1.conf;
a2ensite $1;
service apache2 reload;
if [ ! -d "/var/www/$1" ]; then
  mkdir "/var/www/$1";
  echo "<html><head></head><body>Under Construction. Just set up. </body></html>" > /var/www/$1/index.html;
fi
