<?php
    include('../../config/db_connect.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if(isset($_POST['submit'])){
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $content = mysqli_real_escape_string($conn, $_POST["content"]);
      $current_time = time();
      $curr_time = date('Y-m-d H:i:s', $current_time);
      $p_id = 1; // HARD CODE
      $d_id = 2; // HARD CODE
      $post_id = 1; // HARD CODE

      $sql_insert = "INSERT INTO post(p_id, d_id, title, post_content, created_at) VALUES ($p_id, $d_id, '$title', '$content', NOW())";
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