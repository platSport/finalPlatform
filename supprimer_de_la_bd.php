<?php
include("bd2.php");

if (isset($_GET['LicenceNumber'])) {  
    $LicenceNumber = $_GET['LicenceNumber']; 
   

    $query = "DELETE FROM `users` WHERE LicenceNumber = '$LicenceNumber'";
   
    
    $run = mysqli_query($con, $query); // Changed $conn to $con
    if ($run) {  
        header('location:dash.php');  
    } else {  
        echo "Error: " . mysqli_error($con); // Changed $conn to $con
    }  
}

?>
