
<?php
/*

Description: the home of the index page 
Author: Andrew Mao

*/


    // connect database
    include('../../config/db_connect.php');

    // checks if session is started, if not then start it
    if(!isset($_SESSION)) 
    { 
      session_start(); 
    } 
    // setting local variables for storing user data
    $dob = $fname = $lname = $email = $password = $doctor = $hosptial = "";

    // checks if the user ID is set, if not then redirect to sign in page
    if (!isset($_SESSION["id"])) {
      header("location: ../signin_page");
    } else {
      // extract user data from session and stores it in local variables
      $nameData = explode(" ", $_SESSION['name']);
      $fname = $nameData[0];
      $lname = $nameData[1];
      $email = $_SESSION['email'];
      $h_id = $_SESSION['h_id'];
      if ($_SESSION['isPatient']){
        $dob = $_SESSION['dob'];
        $d_id = $_SESSION['d_id'];
      }
    }

    // converts the doctor_id to the doctors name and stores it in a variable for displaying
    if ($_SESSION["isPatient"]){
        $sql = "SELECT * FROM doctor WHERE d_id = {$_SESSION['d_id']}";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);  
        $row = mysqli_fetch_assoc($result);
        $doctor = "Dr. " . " " . $row['first_name'] . " " . $row['last_name'];
    } 
    // converts the hospital_id to the hospitals name and stores it in a variable for displaying
    $sql = "SELECT * FROM hospital WHERE h_id = {$_SESSION['h_id']}";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);  
    $row = mysqli_fetch_assoc($result);
    $hosptial = $row['h_name'] . " " . $row["h_location"];

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Profile Page</title>
    <?php include('../../header/header.php'); ?>
    <link rel="stylesheet" href="profile.css">
    
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
        <?php if ($_SESSION['isPatient']) { ?>
          <p>
          Date of Birth: <?php echo $dob?>
          </p>
          <p>
          Primary Doctor: <?php echo $doctor?>
          </p>
	    <?php } ?>
        <p>
          Priamry Hospital: <?php echo $hosptial?>
        </p>
    </div>
    <div class ="center">
      <a class = "edit" href="edit.php">EDIT PROFILE</a>
    </div>
    <div>
      <form method="post" action="destroy.php">
        <input type="hidden" name="confirm_delete" value="true">
        <button type="submit" class="btn" name="delete" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">DELETE ACCOUNT</button>
      </form> 
    </div>
  </body>
</html>