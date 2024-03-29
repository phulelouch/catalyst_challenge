<?php
function processCSV($filePath) {

    $file = fopen($filePath, 'r');
    $rowCount = 0; 
    $rowLimit = 10000; // Limit for too much data => Denial of service
    while (($data = fgetcsv($file)) !== FALSE) {
        if ($rowCount > $rowLimit ) {
            echo "More than $rowLimit rows, stop, only process $rowLimit rows max\n";
            break;
        }
        var_dump($data);
        $rowCount++;
    }
}

?>