<?php
  //connect to database
  $conn = mysqli_connect('localhost','valeriemv','test1234', 'csce_310_database'); 
  //check connection
  if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
  } 
?>
