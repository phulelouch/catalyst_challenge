<?php

function createDB($conn) {
    $database = 'users'; //I think since the database is fixed, else I would create a DBConfigClass, but I assume this is okay for now

    //prepare all the statements
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $database";
    
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        surname VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE
    )";

    try {
        //create DB, but it should already exits so just in case the bash script don't work
        $conn->query($sqlCreateDB);
        echo "Database 'users' created successfully or already exists\n";
        //select database
        $conn->select_db($database);
        //create table
        $conn->query($sqlCreateTable);
        echo "Table 'users' created successfully or already exists\n";
    } catch (mysqli_sql_exception $e) {
        echo "Error occurred: " . $e->getMessage();
    }
}

?>
