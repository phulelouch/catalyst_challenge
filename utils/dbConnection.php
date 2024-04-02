<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); 

class DatabaseConnection {
    private $conn = null;
    private $maxAttempts = 3; // change to allow 3 time retry 

    public function __construct($host, $username, $password, $database) {
        $attempt = 0;
        while ($attempt < $this->maxAttempts) {
            try {
                $this->conn = new mysqli($host, $username, $password, $database);
                echo "\nConnection success\n";
                return; 
            } catch (mysqli_sql_exception $e) {
                $attempt++;
                echo "Connection attempt $attempt failed: " . $e->getMessage() . "\n";
                if ($attempt >= $this->maxAttempts) {
                    throw new Exception("All connection attempts failed. Please try again later.");
                }
                sleep(2);
            }
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }
}
