<?php

$servername = "localhost:3307";
$username = "root";
$password = "w@2915djkq#";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];

// Retrieve the old photo from the database
$sql = "SELECT photo FROM users WHERE id = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $photo = $row['photo'];
} else {
    $photo = '';
}

if ($_FILES['photo']['name']) {
    $local_target_dir = "uploads/";
    $target_file = $local_target_dir. basename($_FILES["photo"]["name"]);
    $url_target_file = "http://localhost/demo/". $target_file;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if ($check!== false) {
        $uploadOk = 1;
    } else {
        echo "Sorry, the file is not an actual image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["photo"]["size"] > 500000) {
        echo "Sorry, the file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType!= "jpg" && $imageFileType!= "png" && $imageFileType!= "jpeg") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        // Remove the old photo from the uploads folder
        if (file_exists($local_target_dir. $photo)) {
            unlink($local_target_dir. $photo);
        }

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo = $url_target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$sql = "UPDATE users SET name = '$name', email = '$email', photo = '$photo' WHERE id = '$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: ". $conn->error;
}

$conn->close();

?>