<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bd4"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['ID'])) {  
    $id = $_GET['ID']; 
    $query = "DELETE FROM `events` WHERE ID = '$id'";
    $run = mysqli_query($conn, $query); 
    if ($run) {  
        header('location:event.php');  
    } else {  
        echo "Error: " . mysqli_error($conn); 
    }  
}
?>
