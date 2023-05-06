<!-- 
    Description: File to make user edit post
    Author: Hexin Hu
 -->
<?php
    include('../../config/db_connect.php');
    // error checking
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    if (isset($_POST['submit'])) {
        $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        // update
        $sql = "UPDATE post SET title = '$title', post_content = '$content' WHERE post_id = $post_id";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
            exit();
        } else {
            echo 'query error: ' . mysqli_error($conn);
        }
    } else {
        echo "fail";
    }
?>
