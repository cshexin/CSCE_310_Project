<!-- 
  Descriptino: File for making connection to the database
  Author: Andrew Mao, Hexin Hu, Tian Wu, Valerie Villafana
 -->
<?php
  //connect to database
  $conn = mysqli_connect(/*FILL YOUR USER INFORMATION*/); 
  //check connection
  if(!$conn){
    echo 'Connection error: ' . mysqli_connect_error();
  } 
?>
