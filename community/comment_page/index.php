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
    <?php
      $cssFile = 'index.css';
      $cssContent = file_get_contents($cssFile);
      $hash = md5($cssContent); 
    ?>
     <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
  </head>

  <?php include('../../header/header.php'); ?>

  <div class="container"> 
      <div class="post-card">
        <?php echo "<h1>" . htmlspecialchars($currentPost['title']) . "</h1>"; ?>
        <br>
        <?php echo "<p>" . htmlspecialchars($currentPost['body']) . "</p>"; ?>
      </div>
          
      <div class="create-post">
        <form action="insert_comment.php" method="POST">            
          <input id="input" type="text" name="comment" placeholder="Create Comment" required>
          <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
          <input type="submit" name="submit" value="Submit Comment">
        </form>
      </div>

      <div class="post-container">
        <?php foreach($comments as $comment){ ?>
            <div class="post-card">
            <div class="card-content">
                <p><?php echo htmlspecialchars($comment['comment_text']); ?></p>
                <p>
                    <?php echo html_entity_decode($comment['comment_time']); ?>
                    <?php echo html_entity_decode($comment['comment_date']); ?> 
                </p>
            </div>
            </div>
        <?php } ?>
      </div>
  </div>

  <script src="index.js"></script>
  </body>
</html>