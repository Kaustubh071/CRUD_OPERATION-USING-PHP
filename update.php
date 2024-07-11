<?php

$servername = "localhost:3307";
$username = "root";
$password = "w@2915djkq#";
$dbname = "test";


$conn = new mysqli($servername,$username,$password,$dbname);


if($conn -> connect_error)
{
    die("Connection failed: ". $conn->connect_error);
}

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE id = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No data found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}

.container {
    max-width: 400px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}

input[type="text"], input[type="email"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="text"]:focus, input[type="email"]:focus {
    border-color: #aaa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.btn {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #3e8e41;
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        margin: 20px auto;
        padding: 10px;
    }
    .form {
        padding: 10px;
    }
    .form-group {
        margin-bottom: 15px;
    }
}
    </style>
</head>
<body>
    <div class="container">
    <form action="update_user.php" method="post" class="form" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update this user?')">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" id="photo" name="photo">
        <?php if($row['photo']) { ?>
            <br><img src="<?php echo $row['photo']; ?>" width="100" height="100">
        <?php } ?>
    </div>
    <button type="submit" class="btn">Update</button>
</form>
    </div>

    

<?php
$conn->close();
?>
</body>
</html>