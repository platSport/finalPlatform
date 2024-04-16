<?php
include("bd2.php");

if (isset($_GET['LicenseNum'])) {  
    $LicenseNum = $_GET['LicenseNum']; 
    $query = "DELETE FROM `users` WHERE licenseNum = '$LicenseNum'";
    $run = mysqli_query($con, $query); 
    if ($run) {  
        header('location:dash.php');  
    } else {  
        echo "Error: " . mysqli_error($con); 
    }  
}
?>
