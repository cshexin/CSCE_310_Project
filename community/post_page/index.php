
<?php
      // connect database
      include('../../config/db_connect.php');

      // Write query for all posts
      $sql = 'SELECT * FROM post';

      // make query & get result
      $result = mysqli_query($conn, $sql);

      // fetch the resulting rows as an array
      $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $post_id = 1;
      
      mysqli_free_result($result);

      // close connection
      mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
  <head>
    <title>Community Page</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <?php include('../../header/header.php'); ?>  
    
    <div class="container">
    <h1>Community Page</h1>
      <div class="create-post">
          <input id="title-input" type="text" placeholder="Create Title">
          <br>
          <input id="body-input" type="text" placeholder="Create Body">
          <br> 
          <button class="submit-btn"> submit </button>

      </div>

      <div class="post-container">
        <?php foreach($posts as $post){ ?>
          <a href="../comment_page.php/?postid=<?php echo $post['post_id']; ?>" class="card-link"> 
            <div class="post-card">
                <div class="card-content">
                  <h3><?php echo htmlspecialchars($post['title']); ?></h6>
                  <p><?php echo html_entity_decode($post['body']); ?></p>
                </div>
            </div>
          </a>
        <?php } ?>
    </div>
    </div>
    
    <script src="index.js"></script>
  </body>
</html>