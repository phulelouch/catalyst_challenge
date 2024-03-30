<?php
function validateEmail($email) { // In case we want to add more filters? 
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function processCSV($filePath) {

    if (!file_exists($filePath) || !is_readable($filePath)) {
        echo "File not found or not readable: $filePath\n";
        return;
    }

    $file = fopen($filePath, 'r');
    $rowCount = 0; 
    $rowLimit = 10000; // Limit for too much data => Denial of service
    while (($data = fgetcsv($file)) !== FALSE) {
        if ($rowCount > $rowLimit ) {
            echo "More than $rowLimit rows, stop, only process $rowLimit rows max\n";
            break;
        }
        #print_r($data);
        $name = ucfirst(strtolower(trim($data[0])));
        $surname = ucfirst(strtolower(trim($data[1])));
        $email = strtolower(trim($data[2]));
        print("Name: ".$name."\n");
        print("Surname: ".$surname."\n");
        print("Email: ".$email."\n");

        if (!validateEmail($email)) {
            echo "Invalid email format: $email. Skipping.\n";
            continue;
        }

        $rowCount++;
    }
}



?>