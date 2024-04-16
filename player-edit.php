
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="joueur.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title> </title>
</head>
<body>
  
    <div class="container mt-5">

        

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update information of player
                            <a href="dash.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                        session_start();
                        include("bd2.php");
                        if(isset($_GET['id']))
                        {
                            $player_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM users WHERE id='$player_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $player = mysqli_fetch_array($query_run);
                    ?>
                        <form action="code_Update_Player.php" method="POST">
    <input type="hidden" name="player_id" value="<?=$player['id'];?>">

    <div class="mb-3">
        <label> First Name of player</label>
        <input type="text" name="Firstname" value="<?=$player['FirstName'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label> Last Name of player</label>
        <input type="text" name="LastName" value="<?=$player['LastName'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label>Birthday of player</label>
        <input type="date" name="Birthday" value="<?=$player['Birthday'];?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Email of player</label>
        <input type="email" name="Email" value="<?=$player['Email'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label>Height of player</label>
        <input type="text" name="Height" value="<?=$player['Height'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label>Weight of player</label>
        <input type="text" name="Weight" value="<?=$player['Weight'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label>Licence Number of player</label>
        <input type="text" name="LicenceNumber" value="<?=$player['LicenceNumber'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <button type="submit" name="update_player" class="btn btn-primary">Update player</button>
    </div>
</form>

                        <?php
                            }
                        else
                        {
                            echo "<h4> no such id found</h4>";
                        }
                    }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>