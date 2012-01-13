README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
  ServerAdmin ernestex@gmail.com
  DocumentRoot "D:\texai\webapps\next\public"
  ServerName next
  DirectoryIndex index.php
  ErrorLog "logs/next-error.log"
  CustomLog "logs/next-access.log" common
  <Directory "D:\texai\webapps\next\public">
    AllowOverride All
    Allow from All
  </Directory>
</VirtualHost>
