<?php
      // connect database
      include('../../config/db_connect.php');

      // Write query for all posts
      $sql = 'SELECT * FROM post';

      // make query & get result
      $result = mysqli_query($conn, $sql);

      // fetch the resulting rows as an array
      $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
      
      mysqli_free_result($result);

      // close connection
      mysqli_close($conn);

?>


<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="index.css">

    <title>Community Page</title>
  </head>
  <body>
    <h1>Community Page</h1>
    <div class="container">
      <div class="create-post">
          <input id="input" type="text" placeholder="Create Post"  id="my-input" onclick="goToHomepage()">
      </div>

      <div class="post-container">
        <?php foreach($posts as $post){ ?>
          <a href="#" class="card-link">
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