<?php
  //connect to database
  $conn = mysqli_connect('localhost', 'hexin', '123', 'csce_310_database');
  
  //check connection
  if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
  } 
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="index.css">

    <title>Community Page</title>
  </head>
  <body>
    <h1>Community Page</h1>
    <?php echo "Howdy!"?>
    <div class="create-post">
        <input id="input" type="text" placeholder="Create Post"  id="my-input" onclick="goToHomepage()">
    </div>

    <!-- TODO: Waiting for the database -->
    

    <script src="index.js"></script>
  </body>
</html>