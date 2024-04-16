<?php
session_start();
require 'bd2.php';




if(isset($_POST['update_student']))
{
    $player_id = mysqli_real_escape_string($con, $_POST['player_id']);

    $firstName = mysqli_real_escape_string($con, $_POST['Firstname']);
    $lastName = mysqli_real_escape_string($con, $_POST['LastName']);
    $birthday = mysqli_real_escape_string($con, $_POST['Birthday']);
    $email = mysqli_real_escape_string($con, $_POST['Email']);
    $height = mysqli_real_escape_string($con, $_POST['Height']);
    $weight = mysqli_real_escape_string($con, $_POST['Weight']);
    $licencenumber = mysqli_real_escape_string($con, $_POST['LicenceNumber']);



    $query = "UPDATE userss SET FirstName='$firstName', LastName='$lastName', 
    Birthday='$birthday', Email='$email', Height=$height, Weight=$weight, LicenceNumber=$licencenumber 
    WHERE id='$player_id'";
    
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        //$_SESSION['message'] = "player Updated Successfully";
        
        header("Location: dash.php");
        exit(0);
    }
    else
    {
       // $_SESSION['message'] = "player Not Updated";
        header("Location:dash.php");
        exit(0);
    }

}

?>