<?php
      // connect database
      include('../../config/db_connect.php');

      if(!isset($_SESSION)) 
      { 
        session_start(); 
      } 
      $fname = $lname = "";
      $id = 0;

      if (!isset($_SESSION["name"])) {
        header("location: ../signin_page");
      } else {
        $isPatient = $_SESSION['isPatient'];
        $id = $_SESSION["id"];
        $nameData = explode(" ", $_SESSION['name']);
        $fname = $nameData[0];
        $lname = $nameData[1];
      }

      //Display user
      if ($isPatient){
        $sql = "SELECT * FROM patient WHERE  first_name = '$fname' AND last_name = '$lname'";
        echo 'Welcome, Patient: ' . $_SESSION['name'] . ' !';
      } else{
          $sql = "SELECT * FROM doctor WHERE  first_name = '$fname' AND last_name = '$lname'";
          echo 'Welcome, Doctor: ' . $_SESSION['name'] . ' !';
      }

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
      $p_id = null; 
      $d_id = null; 
      if ($isPatient) {
        $p_id = $id;
      } else {
        $d_id = $id;
      }

      // Write query
      $sql = "SELECT * FROM comment WHERE post_id = $post_id";
      $currentPostsql = "SELECT * FROM post WHERE post_id = $post_id";
      if ($p_id !== null) {
        $usersql = "SELECT * FROM patient WHERE p_id = $p_id";
      } else {
        $usersql = "SELECT * FROM doctor WHERE d_id = $d_id";
        $is_doctor = true;
      }


      // make query & get result
      $result = mysqli_query($conn, $sql);
      $currentPostResult = mysqli_query($conn, $currentPostsql);
      $userresult = mysqli_query($conn, $usersql);

      // fetch the resulting rows as an array
      $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $currentPost = mysqli_fetch_assoc($currentPostResult);
      $user = mysqli_fetch_assoc($userresult);

      mysqli_free_result($result);
      mysqli_free_result($currentPostResult);
      mysqli_free_result($userresult);
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
          <?php
            if ($isPatient) {
              echo '<input type="hidden" name="p_id" value="' . $p_id . '">';
            } else {
              echo '<input type="hidden" name="d_id" value="' . $d_id . '">';
            }
          ?>
          <input type="hidden" name="is_Patient" value="<?php echo $isPatient; ?>">
          <input type="submit" name="submit" value="Submit Comment">
        </form>
      </div>

      <div class="post-container">
        <?php foreach($comments as $comment){ ?>
            <div class="post-card">
            <div class="card-content">
                <?php
                  if ($comment['p_id'] == null) {
                    // Query doctor table to get doctor name
                    $d_id = $comment['d_id'];
                    $doctor_sql = "SELECT * FROM doctor WHERE d_id = $d_id";
                    $doctor_result = mysqli_query($conn, $doctor_sql);
                    $doctor = mysqli_fetch_assoc($doctor_result);
                    $doctor_lastname = htmlspecialchars($doctor['last_name']);
                    $doctor_firstname = htmlspecialchars($doctor['first_name']);
                    
                    echo "<p> <span class='comment-user'> Dr. " . $doctor_firstname . $doctor_lastname .": </span> <p>";
                  } else {
                    // Query patient table to get patient name
                    $p_id = $comment['p_id'];
                    $patient_sql = "SELECT * FROM patient WHERE p_id = $p_id";
                    $patient_result = mysqli_query($conn, $patient_sql);
                    $patient = mysqli_fetch_assoc($patient_result);
                    $patient_lastname = htmlspecialchars($patient['last_name']);
                    $patient_firstname = htmlspecialchars($patient['first_name']);
                    
                    echo "<p> <span class='comment-user'>" . $patient_firstname . $patient_lastname .": </span> <p>";
                  }
                ?>
                <p><?php echo htmlspecialchars($comment['comment_text']); ?></p>
                <p>
                  <?php echo "<span class='comment-meta'>Comment at " . html_entity_decode($comment['comment_time']) . "</span>"; ?>
                  <?php echo "<span class='comment-meta'>on " . html_entity_decode($comment['comment_date']) . "</span>"; ?>
                </p>
                <?php 
                  if ($comment['p_id'] == $p_id && $comment['d_id'] == $d_id) {
                    echo "<div class='buttons-container'>";               
                      // Deletion
                      echo "<form class='delete-form' action='delete_comment.php' method='post'>";
                      echo "<input type='hidden' name='comment_id' value='" . $comment['comment_id'] . "'>";
                      echo "<input type='hidden' name='post_id' value='" . $post_id . "'>";
                      echo "<input type='submit' name='delete' value='Delete'>";
                      echo "</form>";

                      // Edit Button
                      echo "<button class='edit-button' onclick='toggleEditForm(" . $comment['comment_id'] . ")'>Edit</button>";
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

  <?php
  // close connection
  mysqli_close($conn);
  ?>
  <script src="edit_comment.js"></script>
  </body>
</html>