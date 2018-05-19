# MVC Assignment

A link sharing platform developed as a part of MVC Assignment by SDSLabs.

## Setup

1. Install all the dependencies using ```composer install```
2. Import the database using ```config/schema.sql```
3. Copy the sample config file ```config/database.php.example``` to ```config/database.php```
4. Edit the ```config/dadtabase.php``` according to your SQL Credentials.
5. Copy the file ```config/config.conf``` to your ```sites-availible``` directory of apache2
6. Add ```127.0.0.1	mvc.sdslabs.local``` to your hosts file (```etc/hosts```).
7. Run the following commands -
	```
	$ sudo a2enmod rewrite
	$ sudo service apache2 restart
	$ composer dump-autoload
	```
8. The website is set up locally at ```mvc.sdslabs.local```