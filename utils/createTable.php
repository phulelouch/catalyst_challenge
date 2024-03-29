<?php

function createDB($conn, $database) {
    //create DATABASE users
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn->query($sqlCreateDB) === TRUE) {
        echo "Database created successfully or already exists\n";
    } else {
        echo "Error creating database: " . $conn->error;
        return;
    }

    $conn->select_db($database);

    //Create TABLE users

    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE
    )";    
    

    if ($conn->query($sqlCreateTable) === TRUE) {
        echo "Table 'users' created successfully or already exists\n";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

?>