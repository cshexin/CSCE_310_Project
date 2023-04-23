
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
      $post_id = 1; // HARD CODE
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
    <script src="index.js"></script>

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
            <div class="post-card" id="post-<?php echo $post['post_id']; ?>">
                <div class="card-content">
                  <h3>
                    <a href="../comment_page.php/?postid=<?php echo $post['post_id']; ?>" class="card-link"> 
                      <?php echo htmlspecialchars($post['title']); ?>
                    </a>
                  </h3>
                  <p><?php echo html_entity_decode($post['post_content']); ?></p>

                  <div class="post-options">
                      <?php if ($post['p_id'] == 1) {?>
                        <button class="delete-btn">Delete</button>
                        <button class="edit-btn"  onclick="showEditForm(<?php echo $post['post_id']; ?>)">Edit</button>
                      <?php } ?>
                  </div>                                    
                </div>
                <form method="post" action="./edit.php" class="edit-form" id="edit-post-<?php echo $post['post_id']; ?>" style="display: none;">
                  <input placeholder="Edit Title" type="text" name="title" id="edit-title">
                  <br>
                  <input type="text" name="content" id="edit-content">
                  <br>
                  <button type="submit" name="submit" class="submit-btn">Save</button>
                  <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                </form>
            </div>
        <?php } ?>
      </div>

    </div>
  </body>
</html>