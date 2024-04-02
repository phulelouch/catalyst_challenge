<?php
  include 'utils/showHelp.php';
  include 'utils/createTable.php';
  include 'utils/processCsv.php';
  include 'utils/dbConnection.php';
  // Test connection
  // In here I set default username and password, which is not a good security practice. But in return for fast testing/debuging without args -> efficiency
  $options = getopt("u:p:h:", ["file:", "create_table", "dry_run", "help"]);

  $host = $options["h"] ?? 'localhost'; 
  $username = $options["u"] ?? 'phulelouch'; 
  $password = $options["p"] ?? 'phulelouch'; 
  $database = 'users'; 

  try {
    $dbConnection = new DatabaseConnection($host, $username, $password, $database);
    $conn = $dbConnection->getConnection();
  } catch (Exception $e) {
      // Handle exception
      echo 'Caught exception: ',  $e->getMessage(), "\n";
      exit;
  }

  //Show help options
  if (isset($options["help"])) {
      showHelp();
      exit;
  }

  //Create table
  if (isset($options["create_table"])) {
    createDB($conn);
  }

  #Dry run option
  $isDryRun = isset($options["dry_run"]);
  if ($isDryRun and !isset($options["file"])){
    die("You need to provide --file 'filepath' to use dry_run\n");
  }

  //File option
  if (isset($options["file"])) {
    processCsv($options['file'], $conn, $isDryRun);
  }

  


  $dbConnection->close();
?>
