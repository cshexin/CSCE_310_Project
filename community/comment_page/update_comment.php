<?php
include('../../config/db_connect.php');

if (isset($_POST['update']) && isset($_POST['comment_id']) && isset($_POST['post_id']) && isset($_POST['comment_text'])) {
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    $sql = "UPDATE comment SET comment_text = '$comment_text' WHERE comment_id = $comment_id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?postid=$post_id&message=Comment+updated+successfully");
        exit;
    } else {
        header("Location: index.php?postid=$post_id&error=Error+updating+comment%3A+" . urlencode(mysqli_error($conn)));
        exit;
    }
}
?>