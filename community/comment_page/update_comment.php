<!-- Description: This .php file is used for editing new the comments.
Author: Tian Wu -->

<?php
// Include database connection
include('../../config/db_connect.php');

// Check if the update request is set and required fields are not empty
if (isset($_POST['update']) && isset($_POST['comment_id']) && isset($_POST['post_id']) && isset($_POST['comment_text'])) {
    
    // Assign POST data to variables
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    // Prepare the SQL query to update the comment
    $sql = "UPDATE comment SET comment_text = '$comment_text' WHERE comment_id = $comment_id";
    
    // Execute the query and check for success
    if (mysqli_query($conn, $sql)) {
        // If successful, redirect to the post with a success message
        header("Location: index.php?postid=$post_id&message=Comment+updated+successfully");
        exit;
    } else {
        // If unsuccessful, redirect to the post with an error message
        header("Location: index.php?postid=$post_id&error=Error+updating+comment%3A+" . urlencode(mysqli_error($conn)));
        exit;
    }
}
?>