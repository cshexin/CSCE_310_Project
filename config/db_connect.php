<?php
  //connect to database
  $conn = mysqli_connect(/*fill in your user information*/); 
  
  //check connection
  if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
  } 
?>
