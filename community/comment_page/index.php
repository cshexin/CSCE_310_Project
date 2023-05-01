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
      $p_id = 1; //hard code
      $d_id = 1; //hard code
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
        <?php if (isset($currentPost['title'])) echo "<h1>" . htmlspecialchars($currentPost['title']) . "</h1>"; ?>
        <br>
        <?php if (isset($currentPost['post_content'])) echo "<p>" . htmlspecialchars($currentPost['post_content']) . "</p>"; ?>
      </div>
          
      <div class="create-post">
        <!-- Insertion -->
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
                    <?php echo 'Comment at '. html_entity_decode($comment['comment_time']); ?>
                    <?php echo 'on '. html_entity_decode($comment['comment_date']); ?> 
                </p>
                <?php 
                  if ($comment['p_id'] == $p_id && $comment['d_id'] == $d_id) {
                    echo "<div class='buttons-container'>";               
                      // Deletion
                      echo "<form action='delete_comment.php' method='post'>";
                      echo "<input type='hidden' name='comment_id' value='" . $comment['comment_id'] . "'>";
                      echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
                      echo "<input type='submit' name='delete' value='Delete'>";
                      echo "</form>";
                      echo "<p> &nbsp; </p>";
                      // Edit Button
                      echo "<button onclick='toggleEditForm(" . $comment['comment_id'] . ")'>Edit</button>";
                    echo "</div>";
                  }
                ?>
                <!-- Edition-->
                <div class="edit-form" id="edit-form-<?php echo $comment['comment_id']; ?>" style="display:none;">
                    <form class="edit-comment-form" method="POST" action="update_comment.php">
                        <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <textarea name="comment_text" rows="4" cols="50" required><?php echo htmlspecialchars($comment['comment_text']); ?></textarea>
                        <br>
                        <input type="submit" name="update" value="Update Comment">
                    </form>
                </div>
            </div>
            </div>
        <?php } ?>
      </div>
  </div>

  <script src="edit_comment.js"></script>
  </body>
</html>