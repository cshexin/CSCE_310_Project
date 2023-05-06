<?php
/*

Description: logout script to reset all session variables and redirects to home page
Author: Andrew Mao

*/

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>