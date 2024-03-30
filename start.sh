#!/bin/bash

if [ "$1" = '/bin/bash' ]; then
	service mysql start
	#This is for test connection will remove later
	sleep 1
	mysql -e "CREATE DATABASE IF NOT EXISTS users;"
	mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
	mysql -e "GRANT ALL PRIVILEGES ON users.* TO 'phulelouch'@'localhost';"
	mysql -e "FLUSH PRIVILEGES;"

	exec "$@"

elif [ "$1" = 'web' ]; then
	service mysql start
	#This is for test connection will remove later
	sleep 1
	mysql -e "CREATE DATABASE IF NOT EXISTS users;"
	mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
	mysql -e "GRANT ALL PRIVILEGES ON users.* TO 'phulelouch'@'localhost';"
	mysql -e "FLUSH PRIVILEGES;"
	echo "Start the front end at port 3000, remember to add -p 3000:3000 run docker"
	php -S 0.0.0.0:3000 -t /usr/src/app

else

	service mysql start
	sleep 1
	#This is for test connection will remove later
	mysql -e "CREATE DATABASE IF NOT EXISTS users;"
	mysql -e "CREATE USER IF NOT EXISTS 'phulelouch'@'localhost' IDENTIFIED BY 'phulelouch';"
	mysql -e "GRANT ALL PRIVILEGES ON users.* TO 'phulelouch'@'localhost';"
	mysql -e "FLUSH PRIVILEGES;"

	php /usr/src/app/user_upload.php "$@"
fi
