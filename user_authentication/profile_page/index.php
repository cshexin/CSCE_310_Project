
<?php
    // connect database
    include('../../config/db_connect.php');

    if(!isset($_SESSION)) 
    { 
      session_start(); 
    } 
    $dob = $fname = $lname = $email = $password = "";

    if (!isset($_SESSION["name"])) {
      header("location: ../signin_page");
    } else {
      $nameData = explode(" ", $_SESSION['name']);
      $fname = $nameData[0];
      $lname = $nameData[1];
      $email = $_SESSION['email'];

    }
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Profile Page</title>
    <!-- <link rel="stylesheet" type="text/css" href="index.css"> -->
    <?php include('../../header/header.php'); ?>
    
    <div class="container">
      <h1>Profile Page</h1>
        <p>
          First Name: <?php echo $fname?>
        </p>
        <p>
          Last Name: <?php echo $lname?>
        </p>
        <p>
          Email: <?php echo $email?>
        </p>
    </div>
    <div>
      <a href="edit.php">EDIT PROFILE</a>
    </div>
    <div>
      <a href="destroy.php">DELETE ACCOUNT</a>
    </div>
  </body>
</html>