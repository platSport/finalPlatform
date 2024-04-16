<?php
session_start();
include("bd2.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Check if the user exists in the database
        $query = "SELECT * FROM userss1 WHERE email='$email' AND password='$password'";
        $result = mysqli_query($con, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['supervisor_id'] = $row['id'];
                $_SESSION['email'] = $email;
               
                //echo $_SESSION['supervisor_id'];
                // Redirect the user to the dashboard
                header("Location: dash.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Error executing query: " . mysqli_error($con);
        }
    } else {
        echo "Email and password are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="indexx.css">
</head>
<body>
<div class="wrapper">
    <div class="login-box">
        <div class="login-header">
            <span>Login</span>
        </div>
        <form method="POST">
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
            <div class="input_box">
                <input type="submit" class="input-submit" value="Login">
            </div>
            <div class="register">
                <span>Don't have an account? <a href="registration_form.php">Register</a></span>
            </div>
        </form>
    </div>
</div>
</body>
</html>
