<?php
    include('../../config/db_connect.php');

    // Error checking
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if(isset($_POST['delete'])){
        $post_id = mysqli_real_escape_string($conn, $_POST["post_id"]);
        $sql_delete = "DELETE FROM post WHERE post_id=$post_id";
        
        if(mysqli_query($conn, $sql_delete)){
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
      } else {
        print_r ($_POST);
      }
?>
