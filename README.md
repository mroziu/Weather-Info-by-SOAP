# README #

Weatherinformation by SOAP - built with CodeIgniter MVC Framework
- http://www.damianmrozek.pl/weatherinfo

Frontend available to every user of the website, which allows you to select the city from the list predefined cities and check the status of your current weather. In the case of the instantaneous lack of connections with external services solution display the last recorded information from the database. The application refresh the information weather without reloading the page. Backend available only for the administrator, which allows you to: Configure the address of a web service used to retrieve the data (Only one by now). Configure a timeout for SOAP requests. Editing a list of cities (adding, deleting, editing) stored in the database.


# Requirements #
Testing on:
 PHP 5.5.9,
 MySQL 5.543,
 The mod_rewrite Apache module.

# Instalation #
1. Create database weatherDB (InnoDB)
2. Import database from weather.sql file (database directory)
3. Copy all files to your www directory.

# Configuration #
database.php file (application/config directory):
$db['default']['hostname'] = database server address;
$db['default']['username'] = username;
$db['default']['password'] = password;
$db['default']['database'] = database name;

# Test accounts #
login: admin,
password: test
