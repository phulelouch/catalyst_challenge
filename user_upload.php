<?php
  // Test connection
  $options = getopt("u:p:h:");
  $host = $options["h"] ?? 'localhost'; 
  $username = $options["u"] ?? 'root'; 
  $password = $options["p"] ?? ''; 
  $database = 'users'; 

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } else {
      echo "\nSuccess\n";
  }


  $conn->close();
?>
