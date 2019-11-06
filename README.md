# SOFADB
# Society of Forensic Anthropologists
# Forensic Anthropology Case Database (FADAMA)


# Installation

## Prerequisites
- PHP
- PHP Mysql

1. Clone the source from GitHub, or check out the latest release and put the code in /htdocs/sofadb/

2.  Create an alias in apache configs that points to the html folder.  
```
Alias /sofadb /var/www/sofadb/html
```
3.  Run sql/sofadb.sql on the mysql server.

```mysql -u root -p sofadb < sql/sofadb.sql```

4.  Create a user/password on the mysql server which has select/insert/delete/update permissions on the cluster_accounting database.
```
CREATE USER 'saswo_dbadmin'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT SELECT,INSERT,DELETE,UPDATE ON sofadb.* to 'saswo_dbadmin'@'localhost';
```

5. Run the additional .sql files to populate the information databases
```mysql -u root -p sofadb < sql/methods.sql
mysql -u root -p sofadb < sql/method_infos.sql
mysql -u root -p sofadb < sql/method_info_options.sql
mysql -u root -p sofadb < sql/reference.sql
mysql -u root -p sofadb < sql/method_info_reference_list.sql
mysql -u root -p sofadb < sql/input_types.sql
```

6.  Edit /conf/settings.inc.php to reflect your settings.

7.  Run composer to install php dependencies

```composer install```
 
Copy the created /vendor folder to the /html folder.


