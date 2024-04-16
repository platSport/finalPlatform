<?php
session_start();
include("bd2.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data sent via AJAX
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $height = $_POST['height'];
    $licenseNumber = $_POST['licenseNumber'];

    // Retrieve the coach's ID from the session
    $coach_id = $_SESSION['supervisor_id']; // Assuming you stored the coach's ID as 'supervisor_id' in the session

    // Check if the player already exists for the current coach
    $query_check_player = "SELECT COUNT(*) AS num_players FROM event_players WHERE licenseNumber = ? AND supervisor_id = ?";
    $stmt_check_player = mysqli_prepare($con, $query_check_player);

    if ($stmt_check_player) {
        mysqli_stmt_bind_param($stmt_check_player, "si", $licenseNumber, $coach_id);
        mysqli_stmt_execute($stmt_check_player);
        mysqli_stmt_bind_result($stmt_check_player, $num_players);
        mysqli_stmt_fetch($stmt_check_player);
        mysqli_stmt_close($stmt_check_player);

        // If num_players is greater than 0, the player already exists
        if ($num_players > 0) {
            echo "Player with license number already exists.";
        } else {
            // Insert player data into the database
            $query_insert_player = "INSERT INTO event_players (firstName, lastName, height, licenseNumber, supervisor_id) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert_player = mysqli_prepare($con, $query_insert_player);

            if ($stmt_insert_player) {
                // Bind parameters including the coach's ID
                mysqli_stmt_bind_param($stmt_insert_player, "ssisi", $firstName, $lastName, $height, $licenseNumber, $coach_id);
                // Execute the query
                if (mysqli_stmt_execute($stmt_insert_player)) {
                    echo "Player successfully added.";
                } else {
                    echo "Error adding player.";
                }
                mysqli_stmt_close($stmt_insert_player);
            } else {
                echo "Error preparing statement.";
            }
        }
    } else {
        echo "Error preparing statement.";
    }
}
?>
