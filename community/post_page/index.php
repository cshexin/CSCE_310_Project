
<?php
    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

    // connect database
    include('../../config/db_connect.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Get the form data
    if(isset($_POST['submit'])){
      $title = mysqli_real_escape_string($conn, $_POST["title"]);
      $content = mysqli_real_escape_string($conn, $_POST["content"]);
      $current_time = time();
      $curr_time = date('Y-m-d H:i:s', $current_time);
      $p_id = 1; // HARD CODE
      $d_id = 2; // HARD CODE

      echo $p_id . $d_id . $title . $content . $curr_time;

      $sql_insert = "INSERT INTO post(p_id, d_id, title, post_content, created_at) VALUES ($p_id, $d_id, '$title', '$content', NOW())";
      
      if(mysqli_query($conn, $sql_insert)){
        if(mysqli_affected_rows($conn) > 0){
          //success
          header('Location: index.php');
          exit();
        } else {
          echo 'querry error: No rows were affected';
        }
      } else {
        echo 'querry error: ' . mysqli_error($conn);
      }
    } 


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
    <title>Community Page</title>
    <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    <?php include('../../header/header.php'); ?>  
    
    <div class="container">
    <h1>Community Page</h1>
      <form method="post" action="index.php" class="create-post">
          <input id="title-input" type="text" placeholder="Create Title" name="title">
          <br>
          <input id="content-input" type="text" placeholder="Create Content" name="content">
          <br> 
          <button class="submit-btn" type="submit" value="submit" name="submit" > submit </button>
      </form>

      <div class="post-container">
        <?php foreach($posts as $post){ ?>
          <a href="../comment_page.php/?postid=<?php echo $post['post_id']; ?>" class="card-link"> 
            <div class="post-card">
                <div class="card-content">
                  <h3><?php echo htmlspecialchars($post['title']); ?></h6>
                  <p><?php echo html_entity_decode($post['post_content']); ?></p>
                  <div class="post-options">
                    <form method="post" action="index.php" class="edit-post">
                      <?php if ($post['p_id'] == 1) {?>
                        <button class="delete-btn">Delete</button>
                        <button class="edit-btn">Edit</button>
                      <?php } ?>
                    </form>
                  </div>
                </div>
            </div>
          </a>
        <?php } ?>
      </div>

    
    <script src="index.js"></script>
  </body>
</html>