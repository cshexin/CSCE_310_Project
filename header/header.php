<?php

// // connect database
include('../../config/db_connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

if(!isset($_SESSION["id"])){
    header("location: ../signin_page");
    exit;
} else{
    echo $_SESSION["name"];
}
?>
 
    <link rel="stylesheet" type="text/css" href="../../header/header.css">
</head>

<body>
    <nav>
        <div class="navbar-items">
            <a class="nav-item" href="#">Profile</a>
            <a class="nav-item" href="#">Community</a>
        </div>

        <a class="web-title" href="#">Howdy Healthy</a>
        
        <div class="navbar-items">
            <a class="nav-item" href="#">Appointment</a>

            <a class="nav-item" href="/CSCE_310_Project/user_authentication/signin_page/logout.php">Log out</a>
        </div>
    </nav>

