#!/bin/bash

service mysql start

mysql -e "CREATE DATABASE IF NOT EXISTS mydatabase;"
mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
mysql -e "GRANT ALL PRIVILEGES ON mydatabase.* TO 'phulelouch'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

php /usr/src/app/user_upload.php "$@"
