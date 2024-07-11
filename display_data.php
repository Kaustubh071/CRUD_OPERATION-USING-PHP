<!DOCTYPE html>
<html>
<head>
    <title>Display Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div id="data-container">
        <button type="button" class="btn-delete" onclick="location.href='Add.php'">Add</button>
        <?php
        include 'fetch_data.php';
        if (!empty($data)) {
            echo '<table>';
            echo '<tr><th>Name</th><th>Email</th><th>Photo</th><th>Actions</th></tr>';
            foreach ($data as $row) {
                echo '<tr>';
                echo '<td>'. htmlspecialchars($row['name']). '</td>';
                echo '<td>'. htmlspecialchars($row['email']). '</td>';
                echo '<td><img src="'. $row['photo']. '"></td>';
                echo "<button type='button' class='btn-update' onclick=\"location.href='update.php?id=". $row["id"]. "'\">Update</button> | ";
                echo "<button type='button' class='btn-delete' onclick=\"deleteUser(" . $row["id"] . ")\">Delete</button></td>";
                echo '</tr>';
            }
            echo '</table>';
        }
      ?>

<script>
    function deleteUser(id) {
        // Prompt the user to confirm deletion
        if (confirm("Are you sure you want to delete this user?")) {
            // Send a request to delete.php to delete the user
            location.href = 'delete.php?id=' + id;
        }
    }
    </script>
    </div>
</body>
</html>