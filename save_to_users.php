<?php
// Include database connection
include("basejour.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $height = $_POST['height'];
    $licenseNum = $_POST['licenseNum'];

    // Prepare SQL statement to insert data into the 'users' table
    $query_insert = "INSERT INTO users (FirstName, LastName, Height, LicenseNum) VALUES ('$firstName', '$lastName', '$height', '$licenseNum')";

    // Execute SQL statement
    $result_insert = mysqli_query($con, $query_insert);

    // Check if the insertion was successful
    if ($result_insert) {
        // Return success message
        echo "success";
    } else {
        // Return error message
        echo "error: " . mysqli_error($con);
    }
} else {
    // Return error message if request method is not POST
    echo "Invalid request method.";
}

// Close database connection
mysqli_close($con);
?>