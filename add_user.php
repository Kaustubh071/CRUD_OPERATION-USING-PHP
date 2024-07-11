<?php
// Database connection settings
$servername = "localhost:3307";
$username = "root";
$password = "w@2915djkq#"; // Your MySQL root password
$dbname = "test"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$photo = $_POST['photo'];

$sql = "INSERT INTO users (name, email, photo) VALUES ('$name', '$email', '$photo')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    header('Location: index.php');
} else {
    echo "Error: ". $sql. "<br>". $conn->error;
}

$conn->close();
?>