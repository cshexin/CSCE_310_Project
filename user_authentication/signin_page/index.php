<?php
// connect database
session_start();

include('../../config/db_connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// $email = mysqli_real_escape_string($db, $_POST['email']);
// $password = mysqli_real_escape_string($db, $_POST['password']);


// $query = "INSERT INTO patient (email, password) 
//   			  VALUES('$email', '$password')";
//   	mysqli_query($db, $query);
//   	$_SESSION['email'] = $email;
//   	$_SESSION['success'] = "You are now logged in";
    
?>


<!DOCTYPE html>
<html>

<head>
    <title>Signin to HowdyHealthy</title>
</head>

<body>
    <div class="header">
        <h2>SIGN IN</h2>
    </div>

    <form method="post" action="register.php">
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" value="your email">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p>
            Already a member? <a href="">Sign in</a>
        </p>
    </form>
</body>

</html>