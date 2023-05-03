
<?php
    // Avoiding cache problem when the website hosts
    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

    // Connect database
    include('../../config/db_connect.php');

    // Error checking
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Start SESSION
    if(!isset($_SESSION)){
        session_start();
    }

    ///// Retrive current user's information from the SESSION /////
    $sql_currUser = "";
    $curr_username = $_SESSION["name"];
    $curr_user_id = $_SESSION["id"];
  
    // Split user name into first and last name
    $nameArray = explode(' ', $curr_username);
    $firstName = $nameArray[0];
    $lastName = $nameArray[1];

    // Display current user's information with name and user type
    if ($_SESSION["isPatient"]){
        $sql_currUser = "SELECT * FROM patient WHERE  first_name = '$firstName' AND last_name = '$lastName'";
    } else{
        $sql_currUser = "SELECT * FROM doctor WHERE  first_name = '$firstName' AND last_name = '$lastName'";
    }


    // Write query for all posts
    $sql_post = 'SELECT * FROM post';
    // Write query for all posts
    $sql_post = 'SELECT * FROM post';

    // make query & get result
    $result = mysqli_query($conn, $sql_post);
    // make query & get result
    $result = mysqli_query($conn, $sql_post);

    // fetch the resulting rows as an array
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    mysqli_free_result($result);
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

    <!-- Container for all content -->
    <div class="container">
        <h1>Community Page</h1>
        
        <!--Showing the current user information -->
        <?php if($_SESSION["isPatient"]) {
        echo 'Welcome patient: ' . $curr_username . '!';
        }else{
        echo 'Welcome doctor: ' . $curr_username . '!';
        } ?>

        <!-- Area of creating post -->
        <form method="post" action="./create.php" class="create-post">
            <input id="title-input" type="text" placeholder="Create Title" name="title">
            <br>
            <input id="content-input" type="text" placeholder="Create Content" name="content">
            <br> 
            <button class="submit-btn" type="submit" value="submit" name="submit" > submit </button>
        </form>

        <!-- Container for all posts -->
        <div class="post-container">
            <?php foreach($posts as $post){

                // Retrieve user name for each post
                if($post['p_id'] != NULL){
                    $user_id = $post['p_id'];
                    $user_query = "SELECT first_name, last_name FROM patient WHERE p_id = $user_id";
                } else {
                    $user_id = $post['d_id'];
                    $user_query = "SELECT first_name, last_name FROM doctor WHERE d_id = $user_id";
                }

                $user_result = mysqli_query($conn, $user_query);
                $username = mysqli_fetch_assoc($user_result); ?>

                <!-- Container for each post -->
                <div class="post-card" id="post-<?php echo $post['post_id']; ?>">

                    <!-- Post's content -->
                    <div class="card-content">
                        <h3>
                            <!-- Redirect to the detail of the post by clicking title-->
                            <a href="../comment_page/index.php?postid=<?php echo $post['post_id']; ?>#" class="card-link"> 
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h3>
                        <h6>Posted by <?php echo $username['first_name'] . ' ' . $username['last_name']; ?></h6>
                        <h6>Posted by <?php echo $post['created_at']; ?></h6>
                        <p><?php echo html_entity_decode($post['post_content']); ?></p>
                        
                        <!-- Button of edit and delete (show only if the post is belonging to the current user) -->
                        <div class="post-options">
                            <?php if (($post['p_id'] != NULL)) {
                                if($post['p_id'] == $curr_user_id && $_SESSION["isPatient"]) {
                                    echo "<button class='edit-btn' onclick='showEditForm({$post['post_id']})'>Edit</button>";
                                    echo '<form method="POST" action="./delete.php" class="delete-btn-form">';
                                    echo "<input type='hidden' name='post_id' value='{$post['post_id']}'>";
                                    echo '<button type="submit" name="delete" value="delete" class="delete-btn">Delete</button>';
                                    echo '</form>';
                                }
                                
                            } else {
                                if($post['d_id'] == $curr_user_id && (!$_SESSION["isPatient"])) {
                                    echo "<button class='edit-btn' onclick='showEditForm({$post['post_id']})'>Edit</button>";
                                    echo '<form method="POST" action="./delete.php" class="delete-btn-form">';
                                    echo "<input type='hidden' name='post_id' value='{$post['post_id']}'>";
                                    echo '<button type="submit" name="delete" value="delete" class="delete-btn">Delete</button>';
                                    echo '</form>';
                                }
                            }?>

                        </div> 

                    </div>

                    <!-- shows the editing form only over the displaying if user clicks on edit btn -->
                    <form method="post" action="./edit.php" class="edit-form" id="edit-post-<?php echo $post['post_id']; ?>" style="display: none;">
                        <input placeholder="Edit Title" type="text" name="title" id="edit-title">
                        <br>
                        <input type="text" name="content" id="edit-content">
                        <br>
                        <button type="submit" name="submit" class="submit-btn">Save</button>
                        <!-- send post_id to the $_POST -->
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
  </body>
</html>
