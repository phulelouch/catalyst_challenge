<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
function validateEmail($email) { // In case we want to add more filters? 
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    //$disallowedCharsPattern = "/['!\"={?^*~,|{}+&]/"; //I will make the assumtion here that we will not allow ',!'"
    // I will make the assumtion here that we are not allow special characters so mo'connor@cat.net.nz. won't be valid to me
    $disallowedCharsPattern = "/['!\"={}?^*~|{}+&<>\\[\\]\\(\\)\\$%#;:\\/\\\\]/"; 
    if (preg_match($disallowedCharsPattern, $email)) {
        return false;
    }
    return true;
}

// Filter for name and surname
function filterSpecialChars($string) {
    return preg_replace('/[^A-Za-z0-9\s]/', '', $string);
}

function checkTableExist($conn){
    try {
        $sql = "SHOW TABLES LIKE 'users'";
        $result = $conn->query($sql);
        return $result && $result->num_rows > 0; //if there is table
    } catch (mysqli_sql_exception $e) {
        echo "Database error: " . $e->getMessage() . "\n";
        return false;
    }
}

function emailExists($conn, $email) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    } catch (mysqli_sql_exception $e) {
        echo "Database error: " . $e->getMessage() . "\n";
        return false;
    }
}

function insertDB($conn, $name, $surname, $email){
    if(!checkTableExist($conn)){ //in case table not there
        echo "Table users not found! Creating one now";
        createDB($conn);
    }

    if (emailExists($conn, $email)) {     // incase duplicate email address
        echo "Warning: A user with the email <$email> already exists. Skipping.\n";
        return;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, surname, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $surname, $email);
        $stmt->execute();
        echo "Record inserted: $name $surname <$email>\n";
    } catch (mysqli_sql_exception $e) {
        echo "Error inserting record: " . $e->getMessage() . "\n";
    }
}




function processCSV($filePath, $conn, $isDryRun) {

    if (!file_exists($filePath) || !is_readable($filePath)) {
        echo "File not found or not readable: $filePath\n";
        return;
    }

    try {

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
    } catch (Exception $e) {
        echo "File error: " . $e->getMessage() . "\n";
    }
}



?>