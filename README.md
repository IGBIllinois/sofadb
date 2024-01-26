# SOFADB


[![Build Status](https://github.com/IGBIllinois/sofadb/actions/workflows/main.yml/badge.svg)](https://github.com/IGBIllinois/sofadb/actions/workflows/main.yml)

- Society of Forensic Anthropologists
- Forensic Anthropology Case Database (FADAMA)


# Installation

## Prerequisites
- PHP >= 7.2
- PHP Mysql
- PHP PECL Zip
1. Git clone https://github.com/IGBIllinois/sofadb or download a tag release
```
git clone https://github.com/IGBIllinois/sofadb
```

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
CREATE USER 'sofadb'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT,INSERT,DELETE,UPDATE ON sofadb.* to 'sofadb'@'localhost';
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
```
DEFINE ('DB_USER', '');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', '');
DEFINE ('DB_NAME', '');
DEFINE ('TIMEZONE','');
DEFINE ('ADMIN_EMAIL', array());
DEFINE ('FROM_EMAIL', '');

DEFINE ("ROOT_URL", '');

DEFINE ("SESSION_NAME", "sofadb");
DEFINE ("SESSION_TIMEOUT",7200);

DEFINE ("SMTP_HOST", "localhost");
DEFINE ("SMTP_PORT", "25");
DEFINE ("SMTP_USERNAME","");
DEFINE ("SMTP_PASSWORD","");

DEFINE("DEBUG",false);
DEFINE("ENABLE_LOG",false);
DEFINE("LOG_FILE","");
```
7.  Run composer to install php dependencies

```composer install --no-dev```
 
8. Default username is "admin@admin.com" with password 'password'
* After logging in, change your password

9. If logging is enabled.  Copy conf/log_rotate.conf.dist to /etc/logrotate.d/sofadb and edit the log file path
```
cp conf/log_rotate.conf.dist /etc/logrotate.d/sofadb
```
10. Copy conf/cron.dist to /etc/cron.d/sofadb.  This creates the full reports each night
```
cp conf/cron.dist /etc/cron.d/sofadb
```

