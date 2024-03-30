<?php
function validateEmail($email) { // In case we want to add more filters? 
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $disallowedCharsPattern = "/['!\"]/"; //I will make the assumtion here that we will not allow ',!'"
    if (preg_match($disallowedCharsPattern, $email)) {
        return false;
    }
    return true;
}

function checkTableExist($conn){
    $sql = "SHOW TABLES LIKE 'users'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function insertDB($conn, $name, $surname, $email){
    if(!checkTableExist($conn)){ //in case table not there
        echo "Table users not found! Creating one now";
        createDB($conn);
    }
    $stmt = $conn->prepare("INSERT INTO users (name, surname, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $surname, $email); //Also prevent SQL Injection Reference: https://www.acunetix.com/blog/articles/prevent-sql-injection-vulnerabilities-in-php-applications/

    if ($stmt->execute()) {
        echo "Record inserted: $name $surname <$email>\n";
    } else {
        echo "Error inserting record: " . $stmt->error . "\n";
    }
}

function filterSpecialChars($string) {
        return preg_replace('/[^A-Za-z0-9\s\-\'\.]/', '', $string);
}


function processCSV($filePath, $conn, $isDryRun) {

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

        // incase example like line 8 HAMISH,jones,,ham@seek.com
        if (empty(trim($data[0])) || empty(trim($data[1])) || empty(trim($data[2]))) {
            echo "Warning: Missing data in one of the mandatory fields (name, surname, email). Skipping row.\n";
            continue;
        }

        #print_r($data);
        $name = filterSpecialChars(ucfirst(strtolower(trim($data[0]))));
        $surname = filterSpecialChars(ucfirst(strtolower(trim($data[1]))));
        $email = strtolower(trim($data[2]));
       

        if (!validateEmail($email)) {
            echo "Warning: Invalid email format: $email. Skipping.\n";
            continue;
        }

        // if DryRun options, which I guess for testing. Then just print it out
        if(!$isDryRun){
            insertDB($conn, $name, $surname, $email);
        }else{
            print("Name: ".$name."\n");
            print("Surname: ".$surname."\n");
            print("Email: ".$email."\n");
        }

        $rowCount++;
    }


    fclose($file);
}



?>