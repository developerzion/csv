
<!DOCTYPE html>
<html>
  <head>      
      <title>Devparse</title>
      <link rel="shortcut icon" href="logo.png">
      <link rel="stylesheet" type="text/css" href="style.css">
  </head>

<body>
  <div class="navigation">
    <span><img src="logo.png" class="logo"></span>
    <span>How to Upload CSV Files Into MYSQL Database Using PHP</span>
  </div>

  <?php
    $conn = mysqli_connect("localhost","root", "");
    mysqli_select_db($conn, "workspace");

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
        echo "Records successfully inserted";
      }else{
        echo "Error occured while uploading file";
      }
    }
  ?>

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
    <input type="file" name="csvfile" required>
    <button class="btn" name="uploadfile">Click to upload CSV file</button>
  </form>
</body>

</html>