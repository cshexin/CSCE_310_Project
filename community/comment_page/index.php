<?php
      // connect database
      include('../../config/db_connect.php');

      // Check if the URL contains the "postid" parameter
      if (!isset($_GET['postid'])) {
        // Set the default "postid" value
        $defaultPostId = 1; 

        // Build a new URL, including the "postid" parameter
        $newUrl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "?postid=" . $defaultPostId;

        // Redirect to the new URL
        header("Location: " . $newUrl);
        exit();
      }
      
      $post_id = $_GET['postid'];

      // Write query for all posts
      $sql = "SELECT * FROM comment WHERE post_id = $post_id";
      $currentPostsql = "SELECT * FROM post WHERE post_id = $post_id";

      // make query & get result
      $result = mysqli_query($conn, $sql);
      $currentPostResult = mysqli_query($conn, $currentPostsql);

      // fetch the resulting rows as an array
      $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $currentPost = mysqli_fetch_assoc($currentPostResult);
      
      mysqli_free_result($result);
      mysqli_free_result($currentPostResult);
      // close connection
      mysqli_close($conn);
      
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Comment</title>
  </head>

    <?php include('../../header/header.php'); ?>
    
    <link rel="stylesheet" type="text/css" href="index.css">

    <div class="container">
    <?php echo "<h1>" . htmlspecialchars($currentPost['title']) . "</h1>"; ?>
    <?php echo "<p>" . htmlspecialchars($currentPost['body']) . "</p>"; ?>
      <div class="create-post">
          <input id="input" type="text" placeholder="Create Post"  id="my-input" onclick="goToHomepage()">
      </div>

      <div class="post-container">
        <?php foreach($comments as $comment){ ?>
            <div class="post-card">
                <div class="card-content">
                  <p><?php echo htmlspecialchars($comment['comment_text']); ?></p>
                  <p><?php echo html_entity_decode($comment['comment_date']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>
    

    <script src="index.js"></script>
  </body>
</html>