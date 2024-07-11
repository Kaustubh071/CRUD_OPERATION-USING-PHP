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

// Retrieve data from database
$result = $conn->query("SELECT * FROM users");

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data in a table format
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th><th>Photo</th><th>Actions</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td><img src='" . $row["photo"] . "' alt='Profile Photo'></td>";
    echo "<td>";
    echo "<button type='button' class='btn-update' onclick=\"location.href='update.php?id=". $row["id"]. "'\">Update</button> | ";
    echo "<button type='button' class='btn-delete' onclick=\"deleteUser(" . $row["id"] . ")\">Delete</button></td>";
    echo "</td>";
    echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No data found";
}

$conn->close();
?>