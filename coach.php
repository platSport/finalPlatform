<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bd4"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//Create table for coaches
$sql_create_coaches_table = "CREATE TABLE IF NOT EXISTS coaches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    age INT NOT NULL UNIQUE,
    email VARCHAR(20) NOT NULL
)";
if ($conn->query($sql_create_coaches_table) === TRUE) {
    echo "Coaches table created successfully";
} else {
    echo "Error creating coaches table: " . $conn->error;
}

// Create table for events
$sql_create_events_table = "CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    details TEXT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL
)";
if ($conn->query($sql_create_events_table) === TRUE) {
    echo "Events table created successfully";
} else {
    echo "Error creating events table: " . $conn->error;
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submission to add coaches
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCoach'])) {
    // Escape user inputs for security
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $age = $conn->real_escape_string($_POST['age']);
    $email = $conn->real_escape_string($_POST['email']);

    // Insert into database
    $sql = "INSERT INTO coaches (first_name, last_name, age, email) VALUES ('$first_name', '$last_name', '$age', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Coach added successfully";
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
    <title>Add Coach</title>
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
        #coach-form {
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

        #coach-form h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        #coach-form input,
        #coach-form textarea,
        #coach-form button {
            width: 100%;
            margin-bottom: 10px;
        }

        #coach-form button {
            background-color: #b20b0b;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            padding: 10px;
        }

        #coach-form button:hover {
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

        #coach-table {
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
        <div id="coach-form">
            <h3>Add Coach</h3>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" name="first_name" placeholder="First Name" required><br>
                <input type="text" name="last_name" placeholder="Last Name" required><br>
                <input type="number" name="age" placeholder="Age" required><br>
                <input type="email" name="email" placeholder="Email" required><br>
                <button type="submit" name="addCoach">Add</button>
            </form>
        </div>


        <div id="coach-table">
            <h3>Coaches</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Action</th> 

                </tr>
                <?php
                // PHP code to fetch coaches from the database
                $sql = "SELECT id, first_name, last_name, age, email FROM coaches";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["first_name"] . "</td>
                                <td>" . $row["last_name"] . "</td>
                                <td>" . $row["age"] . "</td>
                                <td>" . $row["email"] . "</td>
                                <td>  <button class='delete-button'><a href='deletecoach.php?ID=".$row['id']."' id='btn'>DELETE</a> </button><!-- Add delete button -->

                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>0 coaches</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
    

</body>
</html>
