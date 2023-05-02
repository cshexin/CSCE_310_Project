<?php
    require_once '../../config/db_connect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
            $comment_text = $_POST['comment'];
            $post_id = $_POST['post_id'];
            
            // Prepare an SQL statement for inserting the comment
            $stmt = mysqli_prepare($conn, "INSERT INTO comment (p_id, d_id, post_id, comment_text, comment_date, comment_time) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
            // Set default values for p_id and d_id
            $default_p_id = 1;
            $default_d_id = 1;
        
            // Get the current date and time
            $current_date = date('Y-m-d');
            $current_time = date('H:i:s');
        
            // Bind the variables to the SQL statement's parameters
            mysqli_stmt_bind_param($stmt, "iiissi", $default_p_id, $default_d_id, $post_id, $comment_text, $current_date, $current_time);
        
            // Execute the SQL statement
            mysqli_stmt_execute($stmt);
        
            // Close the statement
            mysqli_stmt_close($stmt);

            header("Location: ../comment_page/index.php?postid=" . $post_id);
            exit;
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }
    }
?>