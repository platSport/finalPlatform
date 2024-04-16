<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "bd4");
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="joueur.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title> Edit</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update informations of Event
                            <a href="admine.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                        if(isset($_GET['id']))
                        {
                            $admin_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM events WHERE id='$admin_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $admin = mysqli_fetch_array($query_run);
                    ?>
                        <form action="code_Update_Admin.php" method="POST">
    <input type="hidden" name="admin_id" value="<?=$admin['id'];?>">

    <div class="mb-3">
        <label> title of event</label>
        <input type="text" name="title" value="<?=$admin['title'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label> details of event</label>
        <input type="textarea" name="details" value="<?=$admin['details'];?>"  class="form-control">
    </div>
    <div class="mb-3">
        <label>start date </label>
        <input type="datetime-local" name="start date" value="<?=$admin['start_date'];?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>end date</label>
        <input type="datetime-local" name="end date" value="<?=$admin['end_date'];?>" class="form-control">
    </div>
    
    
    
    
    <div class="mb-3">
        <button type="submit" name="update_events" class="btn btn-primary">Update events</button>
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