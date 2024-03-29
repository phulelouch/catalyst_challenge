#!/bin/bash

if [ "$1" = '/bin/bash' ]; then
	service mysql start
	#This is for test connection will remove later
	mysql -e "CREATE DATABASE IF NOT EXISTS users;"
	mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
	mysql -e "GRANT ALL PRIVILEGES ON users.* TO 'phulelouch'@'localhost';"
	mysql -e "FLUSH PRIVILEGES;"
	exec "$@"
else
	service mysql start

	#mysql -e "CREATE DATABASE IF NOT EXISTS users;"
	#mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
	#mysql -e "GRANT ALL PRIVILEGES ON users.* TO 'phulelouch'@'localhost';"
	#mysql -e "FLUSH PRIVILEGES;"

	php /usr/src/app/user_upload.php "$@"
fi
