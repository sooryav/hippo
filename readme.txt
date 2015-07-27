// data.sql will create vendor table and create 2 rows for that data

mysql <databasename> -u userid -p < data.sql

// Install composer 
https://getcomposer.org/doc/01-basic-usage.md

// Composer is needed for laravel, hhvm and most git project installation.
// When we get a project from git, it might contain a file called composer.json.
// If so, then its a candidate for composer installation.

copy composer.phar from installation directory of composer to /usr/local/bin/composer.
This will allow composer to run from anywhere.


// INSTALLING HHVM
https://github.com/facebook/hhvm/wiki/Prebuilt-packages-on-Ubuntu-14.04

These instructions are copied from above URL
# installs add-apt-repository
sudo apt-get install software-properties-common

sudo apt-key adv --recv-keys --keyserver hkp://keyserver.ubuntu.com:80 0x5a16e7281be7a449
sudo add-apt-repository "deb http://dl.hhvm.com/ubuntu $(lsb_release -sc) main"
sudo apt-get update
sudo apt-get install hhvm

//Also, to ensure HHVM fires up at boot, run this...
sudo update-rc.d hhvm defaults 

// Once HHVM is installed, we need to install xhp (I am not sure if it is needed separately
// or not. I tried it because I lost track multiple times

git clone https://github.com/facebook/xhp-lib.git

This comes with composer.json file, so use composer to install it.


When using composer, you will most likely run into the most stupid error message you can ever image
(and totally meaningless and can be ignored). Use --ignore-platform-reqs options for composer installation
For error message such as:
"this package requires hhvm * but you are running this with PHP and not HHVM"

composer install --ignore-platform-reqs


// Setting up HACK for type checking
http://docs.hhvm.com/manual/en/install.hack.bootstrapping.php
-- create empty .hhconfig file in the root of the project
-- run hh_client

// To run HHVM via apache
// Stop apache server
/usr/share/hhvm/install_fastcgi.sh



//hhvm restart
service hhvm restart

Note that the hhvm config is set to filter out only .php and .hh files
to be routed via apache to hhvm, so index.html won't be compiled via hhvm


// Useful config locations
/usr/share/hhvm
/etc/nginx/sites-available/default   -> This config has routing for index.php 
                                        and root location to find index.html for nginx

// nginx
sudo apt-get install nginx
sudo service nginx restart

// To enable hhvm for nginx, run the script at
/usr/share/hhvm/install_fastcgi.sh

// Default Location for nginx index.html file
/usr/share/nginx/html

// reload nginx configs
sudo service nginx reload

// APACHE configs
Document Root for apache is specified in 
/etc/apache2/sites-available/000-default.conf

/etc/apache2/mod-enabled
/etc/apache2/sites-available

manually start/stop apache server commands - it should not be needed.
/etc/init.d/apache2 stop
/etc/init.d/apache2 start
/etc/init.d/apache2 restart

// remove apache2 installation
sudo apt-get remove apache2*

// LARAVEL DOCUMENTATION
Once composer is installed, create composer.json file
and add relevant text for getting laravel

{
    "require": {
        "laravel/installer": "1.1"
    }
}



// above will download laravel!!

Once Laravel downloads, set PATH variable to point to laravel binary

export PATH=$PATH:~/hippo/vendor/bin

After that, create a new laravel project in the directory you want

laravel new <project name>

The above command didn't work for me and several people on various blogs
complained about the same.


// Make the bin file available globally - same as setting PATH
mv composer.phar /usr/local/bin/composer

// Create laravel project!
composer create-project laravel/laravel <project-name>

// To give permissions to a user to read/write files.
sudo chown atul /var/www/html/



LARAVEL Commands

application folder is now called "app" folder
In config folder, change app.php to point to correct URL. 
change database.php to have correct userid/password for Mysql db
in .env file, change the userid password and database name again, otherwise there will be error related to using homestead as user id.

// This creates migration table in DB
sudo php artisan migrate:install

// This creates the migration that allows us to create tables in DB!
sudo php artisan make:migration create_vendor_table
sudo php artisan make:migration add_vendors 

// Go to database/migrations folder. We will see files related to above tables.
// go update the "up" and "down" methods in create_vendor_table and add_vendor_table.

// To execute migrations:
sudo php artisan migrate

// Now go check the db. The tables and data for those tables should be present there :)

// We can rollback migrations by
sudo php artisan migrate:rollback

// Redo can be done simply by:
sudo php artisan migrate


vim commands
http://nvie.com/posts/how-i-boosted-my-vim/


