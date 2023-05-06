<!-- 
    Description: File to make user creates post
    Author: Hexin Hu
 -->

<?php
    include('../../config/db_connect.php');

    // Error checking
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // SESSION
    if(!isset($_SESSION)){
      session_start();
    }
    $sql = "";
    $curr_username = $_SESSION["name"];
    $curr_user_id = $_SESSION["id"];
    
    // Split user name into first and last name
    $nameArray = explode(' ', $curr_username);
    $firstName = $nameArray[0];
    $lastName = $nameArray[1];

    // Retrieve data from FORM
    if(isset($_POST['submit'])){
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $content = mysqli_real_escape_string($conn, $_POST["content"]);
      $current_time = time();
      $curr_time = date('Y-m-d H:i:s', $current_time);
      if ($_SESSION["isPatient"]){
        $p_id = $curr_user_id;
        $sql_insert = "INSERT INTO post(p_id, title, post_content, created_at) VALUES ($p_id, '$title', '$content', NOW())";
      } else {
        $d_id = $curr_user_id; 
        $sql_insert = "INSERT INTO post(d_id, title, post_content, created_at) VALUES ($d_id, '$title', '$content', NOW())";

      }

      // check
      if(mysqli_query($conn, $sql_insert)){
        if(mysqli_affected_rows($conn) > 0){
          //success
          header('Location: index.php');
          exit();
        } else {
          echo 'querry error: No rows were affected';
        }
      } else {
        echo 'querry error: ' . mysqli_error($conn);
      }
    } 
?>
