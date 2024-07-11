<?php

$servername = "localhost:3307";
$username = "root";
$password = "w@2915djkq#";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT photo FROM users WHERE id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $photo_url = $row['photo'];

    // Convert URL to local file path
    $parsed_url = parse_url($photo_url);
    $photo_path = $_SERVER['DOCUMENT_ROOT']. str_replace('/', '\\', $parsed_url['path']);

    // Delete the record from the database
    $sql = "DELETE FROM users WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";

        // Delete the photo from the folder
        if (file_exists($photo_path)) {
            unlink($photo_path);
            echo " Photo deleted successfully";
        } else {
            echo " Photo not found";
        }
    } else {
        echo "Error deleting record: ". $conn->error;
    }
}

$conn->close();
?>