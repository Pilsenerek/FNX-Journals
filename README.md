# Installation guide

## 1. Clone repository

## 2. Configure apache v-host
See example below:

    <VirtualHost fnx.local:80>
        ServerAdmin webmaster@dummy-host.example.com
        DocumentRoot "D:/xampp_7_2/htdocs/FNX/public"
        ServerName fnx.local
        ServerAlias fnx.local
        ErrorLog "logs/fnx.local.error.log"
        CustomLog "logs/fnx.local.custom.log" common
    </VirtualHost>
 
## 3. Run 'composer install' to set backend libraries
If you don't have this program, install composer from https://getcomposer.org/

## 4. Database
### 4.1 Prepare MySQL db
### 4.2 Run script from /sql/db.sql to fill example data
### 4.3 Edit DB setting in /src/Config.php file

## 5 Unit tests
Run: 

    /vendor/bin/phpunit
If you don't have xdebug you can install it or skip coverage raport by adding a --no-coverage option.
Doc: https://phpunit.readthedocs.io/en/7.4/
