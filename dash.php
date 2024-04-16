
<?php
session_start();
include("bd2.php");

// Create the userss1 table if it doesn't exist
$query_create_userss1 = "CREATE TABLE IF NOT EXISTS userss1 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clubname VARCHAR(255) UNIQUE,
    supervisor INT NOT NULL DEFAULT 0,
    dob DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    picture VARCHAR(255) NOT NULL DEFAULT 'default.jpg'
)";
mysqli_query($con, $query_create_userss1);
// Create the users table if it doesn't exist
$query_create_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    FirstName VARCHAR(255) NOT NULL,
    LastName VARCHAR(255) NOT NULL,
    Birthday DATE NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Height INT NOT NULL,
    Weight INT NOT NULL,
    LicenceNumber INT NOT NULL,
    supervisor_id INT NOT NULL
)";
mysqli_query($con, $query_create_users);

// Create the event player table if it doesn't exist
$query_create_event_player = "CREATE TABLE IF NOT EXISTS event_players (
   
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    height INT NOT NULL,
    licenseNumber VARCHAR(255) NOT NULL PRIMARY KEY,
    supervisor_id INT NOT NULL
   
)";
mysqli_query($con, $query_create_event_player);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Validate and sanitize user input
    $firstName = mysqli_real_escape_string($con, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_POST['lastName']);
    $height = intval($_POST['height']);
    $licenseNum = intval($_POST['licenseNum']);

    // Insert data into the users table
    $query_insert_user = "INSERT INTO users (FirstName, LastName, Height, LicenseNum) VALUES ('$firstName', '$lastName', $height, $licenseNum)";
    if (mysqli_query($con, $query_insert_user)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($con);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledash.css">
    <link rel="shortcut icon" type="image/x-icon" href="icons/Paint.png" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <title>MIKS</title>
</head>

<body>
<div class="container">
    <nav>
    <div class="nav-left">
           
         
           <?php
include("bd2.php");

// Requête SQL pour sélectionner tous les utilisateurs
$query = "SELECT * FROM userss1";

$result = mysqli_query($con, $query);

// Vérifier s'il y a des résultats
if (mysqli_num_rows($result) > 0) {
   // Déplacer le pointeur de résultat vers la dernière ligne
   mysqli_data_seek($result, mysqli_num_rows($result) - 1);
   
   // Récupérer les données de la dernière ligne
   $row = mysqli_fetch_assoc($result);

   // Afficher l'image de l'utilisateur
   echo '<img src="' . $row['picture'] . '" alt="Profile Picture">';
   // Afficher le nom du superviseur
   echo "<p>" . $row['supervisor'] . "</p>";

} else {
   // Si aucun utilisateur n'est trouvé, afficher un message
   echo "<p>Non connecté</p>";
}
?>
      
           </div>

            <div class="nav-centre">  
                <div class="search-box">
                    <i class="fas fa-search"></i>



                    <input type="text" placeholder="Rechercher par nom d'utilisateur" oninput="searchByUsername(event)"> 
                </div>
            </div>
            <div class="nav-right">
            <a href="#" class="img"  onclick="exportToExcel()">
                <i class="fas fa-arrow-down"></i>
               <a>

                <img src="images/align-justify-solid.svg" alt="" class="profile-pic" onclick="openCard()">
                
                <div class="card-menu-wrap" id="cardwrap">
                    <div class="card-menu">
                        
                        <a href="#" class="card-menu-items" onclick="logout()">
                            <img src="images/sign-out-alt-solid.svg" alt="">
                            <p>Logout</p>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <div class="main">
            <div class="main-left">
                <a href="#" class="img"onclick="home()">
                <i class="fa-solid fa-house"></i>
                    <p>Home</p>
                </a>
                <a href="joueur.php" class="img" onclick="ajouter()">
                    <i class="fa-solid fa-user-plus"></i>
                    <p>Add Event</p>
                </a>
                <a href="#" class="img" >
                <i class="fa-solid fa-pen"></i>
                    <p>modify Event</p>
                </a>
                <a href="#" class="img" onclick="">
                     <i class="fas fa-chart-line"></i>
                    <p>Statistical</p>
                </a>
                <!--<a href="#" class="img"  onclick="exportToExcel()">
                  <i class="fa-regular fa-file-import"></i>
                   <p>export to Excel</p>
                
                </a>-->
                <a href="#" class="img" onclick="equipe()">
                <i class="fa-solid fa-people-group"></i>
                    <p>Team</p>
                </a>
                <a href="#" class="img-out" onclick="logout()">
                       <i class="fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                </a>
                
               

            </div> 
            <div class="table-container">
           <!--<img src="images/karati2.jpg" alt="" >-->
          <div class="infoclub">
        <?php
        include("bd2.php");
        // Requête SQL pour sélectionner tous les utilisateurs
        $query = "SELECT * FROM userss1";
        $result = mysqli_query($con, $query);

                    // Vérifier s'il y a des résultats
                     if (mysqli_num_rows($result) > 0) {
                      // Déplacer le pointeur de résultat vers la dernière ligne
                      mysqli_data_seek($result, mysqli_num_rows($result) - 1);

                       // Récupérer les données de la dernière ligne
                       if ($row = mysqli_fetch_assoc($result)) {
                        echo '<img src="images/' . $row['picture'] . '" alt="Profile Picture">';
                        echo "<p><strong>Club Name:</strong> " . $row['clubname'] . "</p>";
                        echo "<p><strong>Supervisor:</strong> " . $row['supervisor'] . "</p>";
                        echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
                        echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
                    }
                    
                } else {
                   echo "Aucun utilisateur trouvé.";
             }

             // Fermer la connexion à la base de données
             mysqli_close($con);
            ?>
    </div>
    </div>  
    </div> 
    
    <section class="main-centre">
            <div class="title">
                <h1>Welcome to your dashboard</h1>
                <!--<i class="fas fa-user-cog"></i>-->
            </div>
             <!--<div class="main-skills-wrapper">
                <div class="main-skills">
                    <div class="card">
                        <p>1030 <br/><span>number of Girls</span></p>
                        <i class="fa-solid fa-child-dress"></i>
                    </div>
                    <div class="card">
                        <p>2200 <br/><span>number of Boys</span></p>
                        <i class="fa-solid fa-child card-icon"></i>
                    </div>
                    <div class="card">
                        <p>7000 <br/><span>number of Children</span></p>
                        <i class="fa-solid fa-child card-icon"></i>
                    </div>
                    
                </div>
            </div>-->
            <table border="2" cellspacing="5" class="table1" id="userTable">
                   <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Height</th>
                        <th>License Num</th>
                        <th>Action</th> 
                    </tr>
                    <!--login-->
                    <?php
                    //session_start();
                    include("bd2.php");
                    // Check if the supervisor is logged in
                    if (isset($_SESSION['email'])) {
                        // Retrieve supervisor's information from the database
                        $supervisor_email = $_SESSION['email'];
                        $query_supervisor = "SELECT id FROM userss1 WHERE email='$supervisor_email'";
                        $result_supervisor = mysqli_query($con, $query_supervisor);

                        if ($result_supervisor && mysqli_num_rows($result_supervisor) > 0) {
                            $supervisor_row = mysqli_fetch_assoc($result_supervisor);
                            $supervisor_id = $supervisor_row['id']; // Get supervisor's id

                            // Query to select players associated with the logged-in supervisor
                            $query_players = "SELECT * FROM users WHERE supervisor_id='$supervisor_id'";
                            $result_players = mysqli_query($con, $query_players);

                            // Display the players in the table
                            if (mysqli_num_rows($result_players) > 0) {
                                while ($row = mysqli_fetch_assoc($result_players)) {
                                    // Display player information here
                                    echo "<tr>";
                                    echo "<td>" . $row['FirstName'] . "</td>";
                                    echo "<td>" . $row['LastName'] . "</td>";
                                    echo "<td>" . $row['Height'] . "</td>";
                                    echo "<td>" . $row['LicenceNumber'] . "</td>";
                                    echo "<td> 
                                            
                                            <a href='player-edit.php?id=".$row['id']."' id='btn'><i class='fa-solid fa-pen-to-square'></i> </a>          
                                            <button class='add-button' onclick='moveToSelection(this.parentNode.parentNode)'><i class='fa-solid fa-user-plus'></i></button>
                                            <a href='supprimer_de_la_bd.php?LicenceNumber=".$row['LicenceNumber']."' LicenceNumber='btn'><i class='fa fa-trash'></i></a>
                                          </td>";
                                    // Add more columns as needed
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No players found for this supervisor.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Supervisor not found.</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Supervisor not logged in.</td></tr>";
                    }
                    ?>
                     




                     
                </table>

                <table border="2" cellspacing="5" class="table2" id="selectionTable">
                   <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Height</th>
                        <th>License Num</th>
                        <th>act</th>
                        
                    

                    </tr>
                    
                    <?php
include("bd2.php");

// Check if the supervisor is logged in
if (isset($_SESSION['email'])) {
    // Retrieve supervisor's information from the database
    $supervisor_email = $_SESSION['email'];
    $query_supervisor = "SELECT id FROM userss1 WHERE email='$supervisor_email'";
    $result_supervisor = mysqli_query($con, $query_supervisor);

    if ($result_supervisor && mysqli_num_rows($result_supervisor) > 0) {
        $supervisor_row = mysqli_fetch_assoc($result_supervisor);
        $supervisor_id = $supervisor_row['id']; // Get supervisor's id

        // Query to select players associated with the logged-in supervisor
        $query_players = "SELECT * FROM event_players WHERE supervisor_id='$supervisor_id'";
        $result_players = mysqli_query($con, $query_players);

        // Display the players in the table
        if (mysqli_num_rows($result_players) > 0) {
            while ($row = mysqli_fetch_assoc($result_players)) {
                // Display player information here
                echo "<tr>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['height'] . "</td>"; // <-- Corrected column name
                echo "<td>" . $row['licenseNum'] . "</td>";
                echo "<td> 
                        <i class='fa-solid fa-pen-to-square'></i>         
                        <i class='fa-solid fa-user-plus' onclick='moveToSelection(this.parentNode.parentNode)'></i>
                       
                      </td>";
                // Add more columns as needed
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No players found for this supervisor.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Supervisor not found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>Supervisor not logged in.</td></tr>";
}

// Close the database connection
mysqli_close($con);
?>




   
            
        </section>
            <!--<div class="card">
                 <p> 1030 <br/><span>number of girls </span></p>
                 <i class="fa-solid fa-child-reaching"></i>
              
            </div>
            <div class="card">
            <p><i class="fa-solid fa-child card-icon"></i>1030 <br/><span>number of girls </span></p>
            </div>-->
        
    </div>    
   
    
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="script.js"></script>
    <script>
        function searchByUsername(event) {
            var filter, table, tr, td, i, txtValue;
            filter = event.target.value.toUpperCase();
            table = document.getElementById("userTable");
            tr = table.getElementsByTagName("tr");
            
            // Parcourir  lignes du tableau et masquer  qui ne correspondent pas à la recherche par nom d'utilisateur
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0]; // Récupérer la cellule contenant le nom d'utilisateur
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }       
            }
        }
       
    

        function moveToSelection(row) {
    var firstName = row.querySelector('td:nth-child(1)').textContent;
    var lastName = row.querySelector('td:nth-child(2)').textContent;
    var height = row.querySelector('td:nth-child(3)').textContent;
    var licenseNum = row.querySelector('td:nth-child(4)').textContent;

    // Send AJAX request to add the player to the event_players table
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "add_to_event_players.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText); // Display response from the server
            // Optionally, you can update the UI if needed
            // For example, remove the row from the table after adding the player
            row.parentNode.removeChild(row);
        }
    };
    xhr.send("firstName=" + encodeURIComponent(firstName) + "&lastName=" + encodeURIComponent(lastName) + "&height=" + encodeURIComponent(height) + "&licenseNum=" + encodeURIComponent(licenseNum));
}


     



document.getElementById('exportButton').onclick = function() {
    exportToExcel();
};

function exportToExcel() {
    // Créer un objet WorkBook de SheetJS
    
    var wb = XLSX.utils.table_to_book(document.getElementById('selectionTable'));

    // Convertir le WorkBook en binaire Excel (format .xlsx)
    var wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });

    try {
        // Créer un objet Blob contenant les données Excel
        var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });

        // Créer un objet URL pour le Blob
        var url = window.URL.createObjectURL(blob);

        // Créer un lien <a> pour télécharger le fichier Excel
        var a = document.createElement('a');
        a.href = url;
        a.download = 'selectionTable.xlsx';

        // Ajouter le lien à la page
         document.body.appendChild(a);

        // Cliquer sur le lien pour déclencher le téléchargement
        a.click();

        // Supprimer le lien de la page après le téléchargement
        document.body.removeChild(a);

        // Libérer l'URL de l'objet Blob
        window.URL.revokeObjectURL(url);
    } catch (error) {
       // console.error("Une erreur s'est produite lors de l'exportation vers Excel :", error);
        alert("Une erreur s'est produite lors de l'exportation vers Excel :", error);
    }
}

// Fonction pour convertir une chaîne binaire en tableau
function s2ab(s) {
    var buf = new ArrayBuffer(s.length);
    var view = new Uint8Array(buf);
    for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
    return buf;
}

</script>
<script>
    function removeSelection(row) {
        row.parentNode.removeChild(row);
    
    }
    
</script>
   
</body>
</html>