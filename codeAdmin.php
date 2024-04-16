<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "bd4");



if(isset($_POST['update_events']))
{
    $admin_id = mysqli_real_escape_string($con, $_POST['admin_id']);

    $Title = mysqli_real_escape_string($con, $_POST['title']);
    $Details = mysqli_real_escape_string($con, $_POST['details']);
    $Start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $End_date = mysqli_real_escape_string($con, $_POST['end_date']);
    


    $query = "UPDATE events SET title='$Title', details='$Details', 
    start_date='$Start_date', end_date='$End_date'
    WHERE id='$admin_id'";
    
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        //$_SESSION['message'] = "player Updated Successfully";
        
        header("Location: admine.php");
        exit(0);
    }
    else
    {
       // $_SESSION['message'] = "player Not Updated";
        header("Location:admine.php");
        exit(0);
    }

}

?>