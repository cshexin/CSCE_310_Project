
<?php
    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

    // connect database
    include('../../config/db_connect.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

  if(!isset($_SESSION)){
    session_start();
  }

  // SESSION
  $sql = "";
  $curr_username = $_SESSION["name"];
  $curr_user_id = $_SESSION["id"];
  
  // Split user name into first and last name
  $nameArray = explode(' ', $curr_username);
  $firstName = $nameArray[0];
  $lastName = $nameArray[1];
  
  if ($_SESSION["isPatient"]){
    $sql = "SELECT * FROM patient WHERE  first_name = '$firstName' AND last_name = '$lastName'";
    echo 'patient: ' . $curr_username;
  } else{
    $sql = "SELECT * FROM patient WHERE  first_name = '$firstName' AND last_name = '$lastName'";
    echo 'doctor: ' . $curr_username;
  }




    // Write query for all posts
    $sql_post = 'SELECT * FROM post';

    // make query & get result
    $result = mysqli_query($conn, $sql_post);

    // fetch the resulting rows as an array
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    mysqli_free_result($result);
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
      <form method="post" action="./create.php" class="create-post">
          <input id="title-input" type="text" placeholder="Create Title" name="title">
          <br>
          <input id="content-input" type="text" placeholder="Create Content" name="content">
          <br> 
          <button class="submit-btn" type="submit" value="submit" name="submit" > submit </button>
      </form>

      <div class="post-container">
        <?php foreach($posts as $post){
            $user_id = $post['p_id'];
            $user_query = "SELECT first_name, last_name FROM patient WHERE p_id = $user_id";
            $user_result = mysqli_query($conn, $user_query);
            $username = mysqli_fetch_assoc($user_result); ?>
            <div class="post-card" id="post-<?php echo $post['post_id']; ?>">
                <div class="card-content">
                  <h3>
                    <a href="../comment_page/index.php?postid=<?php echo $post['post_id']; ?>#" class="card-link"> 
                      <?php echo htmlspecialchars($post['title']); ?>
                    </a>
                  </h3>
                  <h6>Posted by <?php echo $username['first_name'] . ' ' . $username['last_name']; ?></h6>
                  <h6>Posted by <?php echo $post['created_at']; ?></h6>
                  <p><?php echo html_entity_decode($post['post_content']); ?></p>

                  <div class="post-options">
                      <?php if ($post['p_id'] == $curr_user_id) {?>
                        <button class="edit-btn"  onclick="showEditForm(<?php echo $post['post_id']; ?>)">Edit</button>
                        <form method="POST" action="./delete.php" class="delete-btn-form">
                            <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                            <button type="submit" name="delete" value="delete" class="delete-btn">Delete</button>
                        </form>
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