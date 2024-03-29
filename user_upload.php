<?php
  include 'utils/showHelp.php';
  // Test connection
  $options = getopt("u:p:h:", ["file:", "create_table", "dry_run", "help"]);
  $host = $options["h"] ?? 'localhost'; 
  $username = $options["u"] ?? 'root'; 
  $password = $options["p"] ?? ''; 
  $database = 'users'; 

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } else {
      echo "\nConnection success\n";
  }

  if (isset($options["help"])) {
      showHelp();
      exit;
  }


  $conn->close();
?>
