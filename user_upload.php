<?php
  include 'utils/showHelp.php';
  include 'utils/createTable.php';
  include 'utils/processCsv.php';
  include 'utils/dbConnection.php';
  // Test connection
  // In here I set default username and password, which is not a good security practice. But in return for fast running command without args -> efficiency
  $options = getopt("u:p:h:", ["file:", "create_table", "dry-run", "help"]);

  $host = $options["h"] ?? 'localhost'; 
  $username = $options["u"] ?? 'phulelouch'; 
  $password = $options["p"] ?? 'phulelouch'; 
  $database = 'users'; 

  //Create connection
  $dbConnection = new DatabaseConnection($host, $username, $password, $database);
  $conn = $dbConnection->getConnection();

  //Show help options
  if (isset($options["help"])) {
      showHelp();
      exit;
  }

  //Create table
  if (isset($options["create_table"])) {
    createDB($conn, $database);
  }

  //Create table
  if (isset($options["file"])) {
    processCsv($options['file']);
  }

  


  $dbConnection->close();
?>
