<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="joueur.css">

<title>Player Information Form</title>
<style>
    fieldset {
        margin-bottom: 20px;
    }
</style>
<script>
    function showMessage(message) {
        alert(message);
    }
</script>
</head>
<body>

<?php
session_start();
include("bd2.php");
//echo $_SESSION['email'];
// Check if the 'player_count' key exists in the session variable
if (!isset($_SESSION['player_count'])) {
    $_SESSION['player_count'] = 1; // If it doesn't exist, initialize it to 1
}

$message = ""; // Initialize the message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form was submitted to add more players
    if (isset($_POST['add_player'])) {
        $_SESSION['player_count']++;
    }

    // Check if players have been added
    if (isset($_POST['submit'])) {
        $player_count = $_SESSION['player_count'];
        $success = true; // Variable to track if all insertions were successful

        for ($i = 1; $i <= $player_count; $i++) {
            $FirstName = $_POST["first_name_$i"];
            $LastName = $_POST["last_name_$i"];
            $Birthday = $_POST["birthday_$i"];
            $Email = $_POST["email_$i"];
            $Height = $_POST["height_$i"];
            $Weight = $_POST["weight_$i"];
            $LicenceNumber = $_POST["license_number_$i"];
            if (!empty($FirstName) && !empty($LastName) && !empty($Birthday) && !empty($Email) && !empty($LicenceNumber)) {
                //echo $_SESSION['email']; 
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            
          $supervisor_email = $_SESSION['email'];
    // Retrieve supervisor's information from the database
         $query_supervisor = "SELECT id FROM userss1 WHERE email='$supervisor_email'";

    $result_supervisor = mysqli_query($con, $query_supervisor);



    if ($result_supervisor) {
        if (mysqli_num_rows($result_supervisor) > 0) {
            $supervisor_row = mysqli_fetch_assoc($result_supervisor);
            $supervisor_id = $supervisor_row['id']; // Get supervisor's id
            
            // Insert player data into the database along with supervisor's id
            $query = "INSERT INTO  users (FirstName, LastName, Birthday, Email, Height, Weight, LicenceNumber, supervisor_id) VALUES ('$FirstName', '$LastName', '$Birthday', '$Email', '$Height', '$Weight', '$LicenceNumber', '$supervisor_id')";
            if (!mysqli_query($con, $query)) {
                $success = false; // Set success to false if any insertion fails
                echo "Error: " . mysqli_error($con); // Output MySQL error for debugging
            }
        } else {
            echo "Supervisor not found in the database."; // Output error message
        }
    } else {
        echo "Error: " . mysqli_error($con); // Output MySQL error for debugging
    }
} else {
    echo "Session variable 'email' not set or empty."; // Output error message
}

            }
        }
        // Clear $_POST array to reset input fields
        $_POST = array();
        // Reset player count to 1
        $_SESSION['player_count'] = 1;

        // Check if all insertions were successful
        if ($success) {
            $message = "Congratulations for participating with us!";
            echo "<script>showMessage('$message');</script>";
        } else {
            $message = "Some players were not added successfully. Please try again.";
            echo "<script>showMessage('$message');</script>";
        }
    }
}
?>


<div id="container">
<div class="wrapper">
<h1>Sign Up</h1>
<p>It's Free and only Takes a Minute</p>
<form method="POST">
    <?php
    $player_count = isset($_SESSION['player_count']) ? $_SESSION['player_count'] : 1;
    for ($i = 1; $i <= $player_count; $i++) {
        echo "<fieldset>";
        echo "<legend>Player $i</legend>"; 
        echo "<label for='first_name_$i'>First Name:</label>";
        echo "<input type='text' id='first_name_$i' name='first_name_$i'   value='" . (isset($_POST["first_name_$i"]) ? $_POST["first_name_$i"] : "") . "' required><br>";
        echo "<label for='last_name_$i'>Last Name:</label>";
        echo "<input type='text' id='last_name_$i' name='last_name_$i'  value='" . (isset($_POST["last_name_$i"]) ? $_POST["last_name_$i"] : "") . "' required><br>";
        echo "<label for='birthday_$i'>Birthday:</label>";
        echo "<input type='date' id='birthday_$i' name='birthday_$i'  value='" . (isset($_POST["birthday_$i"]) ? $_POST["birthday_$i"] : "") . "' required><br>";
        echo "<label for='email_$i'>Email:</label>";
        echo "<input type='email' id='email_$i' name='email_$i' value='" . (isset($_POST["email_$i"]) ? $_POST["email_$i"] : "") . "' required><br>";
        echo "<label for='height_$i'>Height:</label>";
        echo "<input type='text' id='height_$i' name='height_$i'  value='" . (isset($_POST["height_$i"]) ? $_POST["height_$i"] : "") . "'><br>";
        echo "<label for='weight_$i'>Weight:</label>";
        echo "<input type='text' id='weight_$i' name='weight_$i' value='" . (isset($_POST["weight_$i"]) ? $_POST["weight_$i"] : "") . "'><br>";
        echo "<label for='license_number_$i'>License Number:</label>";
        echo "<input type='text' id='license_number_$i' name='license_number_$i'  value='" . (isset($_POST["license_number_$i"]) ? $_POST["license_number_$i"] : "") . "' required><br>";
        echo "</fieldset>";
    }
    ?>
    <button type="submit" value="Submit" name="submit">Enregistrer</button>
    <button type="submit" name="add_player">Add Player</button>
</form>
</div>
</div>
</body>
</html>
