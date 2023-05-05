
<?php
    // connect database
    include('../../config/db_connect.php');

    if(!isset($_SESSION)) 
    { 
      session_start(); 
    } 
    $dob = $fname = $lname = $email = $password = "";

    
    // $_SESSION["isPatient"] = boolean variable 
    // $_SESSION["id"] = p_id or d_id of current logged in user
    // 


    if (!isset($_SESSION["id"])) {
      header("location: ../signin_page");
    } else {
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
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Profile Page</title>
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
        <?php if ($_SESSION['isPatient']) { ?>
          <p>
          Date Of Birth: <?php echo $dob?>
          </p>
          <p>
          Doctor ID: <?php echo $d_id?>
          </p>
	    <?php } ?>
        <p>
          Hospital ID: <?php echo $h_id?>
        </p>
    </div>
    <div>
      <a href="edit.php">EDIT PROFILE</a>
    </div>
    <div>
      <form method="post" action="destroy.php">
        <input type="hidden" name="confirm_delete" value="true">
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">DELETE ACCOUNT</button>
      </form> 
    </div>
  </body>
</html>