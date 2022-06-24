# SOFADB


[![Build Status](https://github.com/IGBIllinois/sofadb/actions/workflows/main.yml/badge.svg)](https://github.com/IGBIllinois/sofadb/actions/workflows/main.yml)

- Society of Forensic Anthropologists
- Forensic Anthropology Case Database (FADAMA)


# Installation

## Prerequisites
- PHP >= 7.2
- PHP Mysql
- PHP PECL Zip
1. Clone the source from GitHub, or check out the latest release and put the code in /htdocs/sofadb/

2.  Create an alias in apache configs that points to the html folder.  
```
Alias /sofadb /var/www/sofadb/html
<Directory /var/www/sofadb/html>
	AllowOverride None
	Require all granted
</Directory>
```

3.  Create the database and a user/password on the mysql server which has select/insert/delete/update permissions on the database.
```
CREATE DATABASE sofadb;
CREATE USER 'sofadb_admin'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT,INSERT,DELETE,UPDATE ON sofadb.* to 'sofadb_admin'@'localhost';
```

4.  Run sql/sofadb.sql on the mysql server.

```mysql -u root -p sofadb < sql/sofadb.sql```


5. Run the additional .sql files to populate the information databases
```
mysql -u root -p sofadb < sql/methods.sql
mysql -u root -p sofadb < sql/method_infos.sql
mysql -u root -p sofadb < sql/method_info_options.sql
mysql -u root -p sofadb < sql/reference.sql
mysql -u root -p sofadb < sql/method_info_reference_list.sql
mysql -u root -p sofadb < sql/prompts.sql
```

6.  Edit /conf/settings.inc.php to reflect your settings.

7.  Run composer to install php dependencies

```composer install```
 
Copy the created /vendor folder to the /html folder.

8. Default username is "admin@admin.com" with password 'password'
* After logging in, change your password


