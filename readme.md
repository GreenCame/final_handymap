# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

# fix bug

## 1)install
You have to install wampserver
     https://sourceforge.net/projects/wampserver/files/WampServer%202/Wampserver%202.5/wampserver2.5-Apache-2.4.9-Mysql-5.6.17-php5.5.12-64b.exe/download
and follow the step in this website:
     http://www.darwinbiler.com/how-to-install-laravel-on-wamp-for-beginners/



## 2) GitHub
Download github desktop
Add the project :
    https://github.com/GreenCame/handymap
My wamp is there: `C:\wamp`
I put the project in `C:\wamp\frameworks\laravel\handymap` so if you change, change the path for next step.



## 3) Make Database
### go to `localhost/phpmyadmin/`
create a New-Database "softwareproject" (the name is very Important) database in UTF-8 generaly
change a root password and put "root" password, in settings phpmyadmin

### configuration
in the file `C:\wamp\apps\phpmyadmin4.1.14\config.inc.php` change that:

        $cfg['Servers'][$i]['user'] = 'root';
        $cfg['Servers'][$i]['password'] = 'root';

### Open cmd in Admin
command:
    cd C:\wamp\frameworks\laravel\handymap
then
    php artisan make:migration v1
    php artisan migrate



## 4) Hosts file
in `C:\Windows\System32\drivers\etc` change the hosts file
add in the end the line :

        127.0.0.1       laravel.dev



## 5) httpd.conf
add in the end of the file "C:\wamp\bin\apache\apache2.4.9\conf\httpd.conf"

        <VirtualHost laravel.dev:80>
          DocumentRoot C:\wamp\frameworks\laravel\handymap\public
          <Directory "C:\wamp\frameworks\laravel\handymap\public">
            Options Indexes FollowSymLinks
            AllowOverride All
            Order allow,deny
            Allow from all
          </Directory>
        </VirtualHost>

Remove the # in line:      "LoadModule rewrite_module modules/mod_rewrite.so"     (line 154 for me)



## 6) Alias (maybe optionnal if you use laravel.dev)
add the file "handymap.conf" in "C:\wamp\alias\" :

        Alias /handymap "C:/wamp/frameworks/laravel/handymap/public"
        <Directory "C:/wamp/frameworks/laravel/handymap/public">
        DirectoryIndex index.php
        Options Indexes FollowSymLinks MultiViews
        AllowOverride all
            Order allow,deny
            allow from all
            Require all granted
        </Directory>



## 7) Restart you computer (important)
Go to laravel.dev, it should work

## 8) Facebook connection fix
Follow this link:
    http://curl.haxx.se/ca/cacert.pem
Copy the entire page and save it in a: "cacert.pem" (in PHP\extras\ssl folder)
Then in your `php.ini` file insert or edit the following line: curl.cainfo = "[pathtothisfile]\cacert.pem"
In config/session.php change the `line`: 'domain' => 'laravel.dev',
Restart service