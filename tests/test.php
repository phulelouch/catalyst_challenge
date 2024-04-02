<?php

function getRandomSpecialChars($length = 1) {
    $specialChars = '!@#$%^&*()_-+=[]{}|;:,.<>?~';
    $charsLength = strlen($specialChars);
    $randomSpecialChars = '';

    for ($i = 0; $i < $length; $i++) {
        $randomSpecialChars .= $specialChars[rand(0, $charsLength - 1)];
    }

    return $randomSpecialChars;
}

function generateRandomData($numEntries) {
    $data = [];
    $domains = ['example.com', 'test.com', 'demo.net'];
    $names = ['John', 'Jane', 'Jim', 'Jill', 'Jack', 'Jenny'];

    for ($i = 0; $i < $numEntries; $i++) {
        $name = $names[array_rand($names)];
        $surname = 'Doe' . getRandomSpecialChars(rand(0, 1)); 
        $email = strtolower($name) . rand(1, 100) . '@' . $domains[array_rand($domains)];

        if (rand(0, 1)) {
            $email = substr_replace($email, getRandomSpecialChars(1), rand(1, strlen($email) - 1), 0);
        }

        $data[] = [$name, $surname, $email,''];
    }

    return $data;
}

function createCSV($filePath, $data) {
    $file = fopen($filePath, 'w');
    if ($file === false) {
        die('Error opening the file ' . $filePath);
    }
    fputcsv($file, ['name', 'surname', 'email', '']);

    foreach ($data as $row) {
        fputcsv($file, $row);
    }

    fclose($file);

    echo "CSV file '$filePath' generated successfully.\n";
}
$testData = generateRandomData(1000);
createCSV('test_data.csv', $testData);

