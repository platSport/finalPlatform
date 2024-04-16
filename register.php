<?php
session_start();
include("bd2.php");

// Create the userss1 table if it doesn't exist
$query = "CREATE TABLE IF NOT EXISTS userss1(
     id INT AUTO_INCREMENT PRIMARY KEY,
    clubname VARCHAR(255) UNIQUE,
    supervisor_id INT,
    dob DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    picture VARCHAR(255) NOT NULL DEFAULT 'default.jpg'
   
)";


// Execute the query to create the table
$result = mysqli_query($con, $query);

// Check if the query failed
if (!$result) {
    die("Error creating table: " . mysqli_error($con));
}

// Handling the user registration form
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $clubname = mysqli_real_escape_string($con, $_POST['clubname']);
    $supervisor = ($_POST['supervisor'] == 'yes') ? 1 : 0;
    $dob = $_POST['date'];
    $email  = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];


    if (!empty($clubname) && isset($supervisor) && !empty($dob) && !empty($email) && !empty($password)) {
        if (isset($_FILES['pp']) && $_FILES['pp']['error'] === UPLOAD_ERR_OK) {
            // File uploaded successfully C:/xampp2/htdocs/platfom/images/
            $uploadDir = '';
            $uploadFile = $uploadDir . basename($_FILES['pp']['name']);
        
            if (move_uploaded_file($_FILES['pp']['tmp_name'], $uploadFile)) {
                $query = "INSERT INTO userss1 (clubname, supervisor, dob, email, password, picture) VALUES (?, ?, ?, ?,?, ?)";
                $statement = mysqli_prepare($con, $query);
        
                if ($statement) {
                   // mysqli_stmt_bind_param($statement, "sissbss", $clubname, $supervisor, $dob, $email, $password, $uploadFile);
                    mysqli_stmt_bind_param($statement, "sissss", $clubname, $supervisor, $dob, $email, $password, $uploadFile);

                    if (mysqli_stmt_execute($statement)) {
                        echo "<script>alert('Data added successfully.');</script>";
                        $_SESSION['supervisor_id'] = $row['id'];
                        $_SESSION['email'] = $email;
                        header("Location: dash.php");
                        exit;
                    } else {
                        echo "ERROR: Unable to execute query. " . mysqli_error($con);
                    }
        
                    mysqli_stmt_close($statement);
                } else {
                    echo "ERROR: Unable to prepare statement. " . mysqli_error($con);
                }
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            // Check specific error types
            switch ($_FILES['pp']['error']) {
                case UPLOAD_ERR_NO_FILE:
                    echo "No file uploaded.";
                    break;
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "Exceeded file size limit.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "The uploaded file was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Missing temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "A PHP extension stopped the file upload.";
                    break;
                default:
                    echo "Unknown error occurred.";
                    break;
            }
        }
    } else {
        echo "All fields are required.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="indexx.css">
</head>
<body>
<div class="wrapper">
    <div class="login-box">
        <div class="login-header">
            <span>Register</span>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="input_box">
                <input type="text" id="clubname" class="input-field" name="clubname" required>
                <label for="clubname" class="label">Club Name</label>
                <i class="bx bx-medal icon"></i>
            </div>
            <div class="input_box">
                <!-- Utiliser un champ de sélection pour le superviseur -->
                <select id="supervisor" class="input-field" name="supervisor" required>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
                <label for="supervisor" class="label">Supervisor</label>
                <i class="bx bx-user icon"></i>
            </div>
            <div class="input_box">
                <input type="date" id="date" class="input-field" name="date">
                <label for="date" class="label">Date of Birth</label>
            </div>
            <div class="input_box">
                <input type="email" id="email" class="input-field" name="email" required>
                <label for="email" class="label">Email</label>
                <i class="bx bx-envelope icon"></i>
            </div>
            <div class="input_box">
                <input type="password" id="password" class="input-field" name="password" required>
                <label for="password" class="label">Password</label>
                <i class="bx bx-lock-alt icon"></i>
            </div>
            
            <div class="mb-3">
		    <label class="form-label">Profile Picture</label>
		    <input type="file" 
		           class="form-control"
		           name="pp">
		  </div>
            <div class="input_box">
                <input type="submit" class="input-submit" value="Register">
            </div>
            <div class="register">
                <span>Already have an account? <a href="indexx.php">Login</a></span>
            </div>
        </form>
    </div>
</div>
</body>
</html>
