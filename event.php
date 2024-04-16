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

// Handling form submission to add events
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $title = $conn->real_escape_string($_POST['eventTitle']);
    $details = $conn->real_escape_string($_POST['eventDetails']);
    $start_date = $conn->real_escape_string($_POST['eventStartDate']);
    $end_date = $conn->real_escape_string($_POST['eventEndDate']);

    // Insert into database
    $sql = "INSERT INTO events (title, details, start_date, end_date) VALUES ('$title', '$details', '$start_date', '$end_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Event added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
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
            position: fixed;
            top: 0;
            left: 0;
            background-color: hsl(0, 88%, 37%);
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
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
            border-radius: 5px;
        }

        .sidebar-menu button:hover {
            background-color: #861a1a;
        }

        /* Center the form within the background */
        .background {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Added to align elements vertically */
            height: 100vh;
        }

        /* Style for the form */
        #event-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
            width: 50%; /* Adjust width as needed */
            max-width: 500px; /* Maximum width for the form */
            margin-bottom: 20px; /* Adjust vertical margin as needed */
        }

        #event-form h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        #event-form input,
        #event-form textarea,
        #event-form button {
            width: 100%;
            margin-bottom: 10px;
        }

        #event-form button {
            background-color: #b20b0b;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            padding: 10px;
        }

        #event-form button:hover {
            background-color: #861a1a;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; /* Added margin to separate table from form */
            margin-left: auto;
            margin-right: auto;
            max-width: 800px; /* Adjusted maximum width */
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #dddddd; /* Apply border to all cells */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #event-table {
            margin-top: 20px; /* Adjust margin as needed */
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
        <div id="event-form">
            <h3>Add Event</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="eventTitle" placeholder="Title" required><br>
                <textarea name="eventDetails" placeholder="Details" required></textarea><br>
                <input type="datetime-local" name="eventStartDate" required><br>
                <input type="datetime-local" name="eventEndDate" required><br>
                <button type="submit">Add</button>
            </form>
        </div>

        <div id="event-table">
            <h3>Events</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Details</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th> 
                </tr>
                <?php
                // PHP code to fetch events from the database
                $sql = "SELECT id, title, details, start_date, end_date FROM events";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["title"] . "</td>
                            <td>" . $row["details"] . "</td>
                            <td>" . $row["start_date"] . "</td>
                            <td>" . $row["end_date"] . "</td>
                            <td>  
                                <button class='delete-button'><a href='deleteevent.php?ID=".$row['id']."' id='btn'>DELETE</a></button>
                                <button class='delete-button'><a href='player-edit-admine.php?id=".$row['id']."' id='btn'>update</a></button>
                            </td> 
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>0 results</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

</body>
</html>
