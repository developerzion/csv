
<!DOCTYPE html>
<html>
  <head>      
      <title>Upload CSV Files Into MYSQL Database Using PHP</title>
      <link rel="shortcut icon" href="logo.png">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
      <link rel="stylesheet" href="font-awesome/css/font-awesome.css">
      <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
  </head>

<body>
  <div class="navigation">
    <span><img src="img/logo.png" class="logo"></span>
    <span>How to Upload CSV Files Into MYSQL Database Using PHP</span>
  </div>

  <?php
    //DEVELOPEMENT
    $conn = mysqli_connect("localhost","root", "","workspace");



    function message($msg, $status){
      return "<div class='col-lg-5 col-lg-offset-3'><div class='alert alert-$status'>$msg</div></div>";
    }

    //Upload the csv file into the database
    if(isset($_POST['uploadfile'])){
      $csvTemp = $_FILES['csvfile']['tmp_name'];
      $getContent = file($csvTemp);

      $result = "";

      for ($i=0; $i < count($getContent); $i++) { 
        if($i == 0) continue;
          $expRow = explode(",", $getContent[$i]);

          $firstname = $expRow[0];
          $surname = $expRow[1];
          $age = $expRow[2];

          $result = mysqli_query($conn, "INSERT INTO tbl_users (`firstname`,`surname`,`age`) VALUES ('$firstname','$surname','$age')");
      }

      if($result){
        echo message("Records successfully inserted",'success');
      }else{
        echo message("Error occured while uploading file",'danger');
      }
    }

    //Delete record from the database
    if(isset($_POST['trash'])){
      $id = $_POST['trashid'];
      $chkTrash = mysqli_query($conn, "DELETE FROM tbl_users WHERE `id`='$id'");
      if($chkTrash){
        echo message("Records successfully deleted",'success');
      }
    }
  ?>

<div class="row">
    <div class="col-lg-5 col-lg-offset-3">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
        <table>
          <tr>
            <td><input type="file" class="form-control" name="csvfile" required></td><td><button class="btn btn-success" name="uploadfile">Click to upload CSV file</button></td>
          </tr>
        </table>
      </form>
      <br>
      <h2>Records</h2>
      <table class="table table-bordered table-hover">
          <tr>
            <td>S/N</td>
            <td>Firstname</td>
            <td>Lastname</td>
            <td>Age</td>
            <td>Action</td>
          </tr>
          <?php
            $chkTable = mysqli_query($conn, "SELECT * FROM tbl_users");
            if(mysqli_num_rows($chkTable) < 1){
              echo "<tr><td colspan='5' style='text-align:center'>No record</td></tr>";
            }else{
              $count = 1;
              while($row = mysqli_fetch_array($chkTable)){ ?>
                <form action="" method="POST">
                  <input type="text" name="trashid" value="<?php echo $row['id']; ?>" hidden>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['firstname']; ?></td>
                    <td><?php echo $row['surname']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><button class="btn btn-danger" name="trash"><span class="fa fa-trash"></span></button></td>
                  </tr>
                </form>
                <?php

              }
            }
          ?>
      </table>
<a target="_blank" href="https://github.com/developerzion"><span class="fa fa-github"></span> Github</a> | <a target="_blank" href="https://www.youtube.com/channel/UCe0t7d9o4kd9gc9_sdUL_TA"><span class="fa fa-youtube"></span> Youtube Channel</a>

    </div>
  </div>
</body>

</html>