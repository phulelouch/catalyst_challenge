<?php
include 'utils/dbConnection.php';
include 'utils/createTable.php';
include 'utils/processCsv.php';
include 'utils/showHelp.php';


$messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $username = 'phulelouch';
    $password = 'phulelouch';
    $database = 'users';

    $dbConnection = new DatabaseConnection($host, $username, $password, $database);
    $conn = $dbConnection->getConnection();

    if (isset($_POST['generate_test'])) {
        ob_start();
        include 'tests/test.php'; 
        $output = ob_get_clean();
        $messages[] = nl2br(htmlspecialchars($output)); // Display output safely
    }

    // file upload
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == UPLOAD_ERR_OK) {
        $uploadedFilePath = $_FILES['csv_file']['tmp_name'];
        processCsv($uploadedFilePath, $conn, isset($_POST['dry_run']));
    }

    if (!empty($_POST['csv_name'])) {
        $uploadedFilePath = 'path/to/csv/directory/' . $_POST['csv_name'];
        if (file_exists($uploadedFilePath)) {
            processCsv($uploadedFilePath, $conn, isset($_POST['dry_run']));
        } else {
            $messages[] = "CSV file does not exist.";
        }
    }

    $dbConnection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Upload</title>
</head>
<body>
    <h1>User Upload Tool</h1>

    <?php foreach ($messages as $message): ?>
        <p><?= $message."\n" ?></p><br>
    <?php endforeach; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="csv_file">CSV file:</label>
            <input type="file" id="csv_file" name="csv_file">
        </div>
        <div>
            <input type="checkbox" id="dry_run" name="dry_run">
            <label for="dry_run">Dry run</label>
        </div>
        <div>
            <button type="submit">Upload and Process</button>
        </div>
    </form>

    <form action="" method="post">
        CSV File Name:
            <input type="text" name="csv_name" placeholder="CSV file name">
            <div>
                <input type="checkbox" id="dry_run" name="dry_run">
                <label for="dry_run">Dry run</label>
            </div>
            <div>
                <button type="submit">Process CSV</button>
            </div>
    </form>

    <form action="" method="post">
        <button type="submit" name="generate_test">Generate Test</button>
    </form>
</body>
</html>
