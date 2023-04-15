<?php
  //connect to database
  $conn = mysqli_connect(/*fill user information from phpmyadmin */); 
  
  //check connection
  if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
  } 
?>
