<?php
    $user = 'root';
    $pass = '';
    $db = 'csce_310_database';
    
    $db = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");
?>