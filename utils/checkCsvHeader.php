<?php
function checkCsvHeader($filePath){
    if (!file_exists($filePath) || !is_readable($filePath)) {
        throw new Exception("File not found or not readable\n");
    }

    $file = fopen($filePath, 'r');
    if (!$file) {
        throw new Exception("Can't open file: $filePath");
    }

    $csvhead = fgetcsv($file);
    fclose($file);
    #var_dump($csvhead);
    $headers = ['name', 'surname', 'email',''];

    if($csvhead !== $headers){
        return false;
    }
    return true;

}



?>