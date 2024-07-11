<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish Form</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #8e44ad, #34a85a);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 400px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }
        .form-container:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }
        .form-container::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.2), transparent);
            z-index: -1;
            transform: rotate(45deg);
        }
        h2 {
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
            text-align: center;
            font-size: 24px;
        }
        label {
            display: block;
            margin: 15px 0 5px;
            font-size: 16px;
            color: #666;
        }
        input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
            width: 94%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }
        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, input[type="file"]:focus {
            border-color: #5cb85c;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        button {
            width: 100%;
            padding: 15px;
            background: #5cb85c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            margin-top: 18px;
        }
        button:hover {
            background: #4cae4c;
            transform: translateY(-2px);
        }
        .success-message, .error-message {
            font-size: 16px;
            margin-top: 15px;
            text-align: center;
        }
        .success-message {
            color: #4cae4c;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $errors = [];

    // Validate input
    if (empty($name) || empty($email) || empty($_POST['password'])) {
        $errors[] = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    } else {
        // File upload
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir. basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check!== false) {
            $uploadOk = 1;
        } else {
            $errors[] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $errors[] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType!= "jpg" && $imageFileType!= "png" && $imageFileType!= "jpeg") {
            $errors[] = "Sorry, only JPG, JPEG, PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errors[] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $_FILES["photo"]["name"];
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, photo) VALUES (?,?,?,?)");
        if (!$stmt) {
            $errors[] = "Error preparing SQL statement: ". $conn->error;
        } else {
            $stmt->bind_param("ssss", $name, $email, $password, $photo);

            // Set parameters and execute
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success = "New record created successfully";
                // Redirect to avoid form resubmission
                header("Location: ".$_SERVER['PHP_SELF']."?success=".urlencode($success));
                exit();
            } else {
                $errors[] = "Error: ". $stmt->error;
            }

            $stmt->close();
        }
    }

    $conn->close();
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p class='error-message'>{$error}</p>";
    }
}

if (isset($_GET['success'])) {
    echo "<p class='success-message'>".$_GET['success']."</p>";
}
?>

        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="photo">Profile Photo</label>
            <input type="file" id="photo" name="photo" required>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>