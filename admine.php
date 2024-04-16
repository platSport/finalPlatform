<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bd4"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed; /* Fixed position for the sidebar */
            top: 0;
            left: 0;
            background-color: hsl(0, 88%, 37%);
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px; /* Added margin to separate header from buttons */
        }

        .sidebar-menu {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu button {
            margin-bottom: 10px;
            padding: 10px;
            width: 80%;
            background-color: #b20b0b;
            border: none ;
            cursor: pointer;
            color: white;
            display: block;
            text-align: center;
            border-radius: 5px; /* Added border radius for button */
        }

        .sidebar-menu button:hover {
            background-color: #861a1a; /* Darkened color on hover */
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 5px; /* Added border radius for modal */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .content {
            position: absolute;
            left: 250px; /* Adjusted to match the width of the sidebar */
            width: calc(100% - 250px); /* Adjusted to match the width of the sidebar */
            padding: 20px; /* Adjusted for spacing */
            box-sizing: border-box; /* Ensure padding is included in width calculation */
            margin-top: 20px; /* Added margin-top */
        }

        #welcome-message {
            text-align: center;
            font-size: 24px;
        }

    </style>
</head>
<body>
<div class="sidebar">
    <h2>Home</h2>
    <div class="sidebar-menu">
        
        <a href="event.php"><button>Add Event</button></a> 
        <a href="coach.php"><button>Add Coach</button></a> 
    </div>
</div>

<div class="background">
    <div class="content" id="main-content">
        <div id="welcome-message">
            <h3>WELCOME!</h3>
        </div>
    </div>
</div>

<script>
    function displayWelcome() {
        document.getElementById("main-content").style.display = "block";
    }
</script>
</body>
</html>
