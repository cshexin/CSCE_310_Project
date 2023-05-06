<!-- 
    Description: This .php file is used for deleting the comments.
    Author: Tian Wu 
-->

<?php 
require_once "../../config/db_connect.php";

if (isset($_POST['comment_id'])) {
    $comment_id = intval($_POST['comment_id']);
    $post_id = intval($_POST['post_id']);
    $stmt = mysqli_prepare($conn, "DELETE FROM comment WHERE comment_id = ?");
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $comment_id);
        // Check if delete successfully.
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php?postid=" . $post_id . "&message=Comment+deleted+successfully");
            exit;
        } else {
            mysqli_stmt_close($stmt);
            header("Location: index.php?postid=" . $post_id . "&error=Error+deleting+comment%3A+" . urlencode(mysqli_error($conn)));            exit;
        }
    } else {
        header("Location: index.php?postid=" . $post_id . "&error=Error+preparing+the+delete+statement%3A+" . urlencode(mysqli_error($conn)));        exit;
    }
} else {
    $defaultPostId = 1;
    header("Location: index.php?postid=" . $defaultPostId . "&error=Error%3A+comment_id+not+set");
    exit;
}
?>