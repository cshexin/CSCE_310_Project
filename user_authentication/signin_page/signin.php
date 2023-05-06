<?php
/*

Description: The sign in page for users to fill in their information
Author: Andrew Mao

*/

// connect database
include('../../config/db_connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// start the session for the session global variable
session_start();

// checks if the user is logged in, if they are, then redirect to the profile page
if(isset($_SESSION["name"])){
    header("location: ../profile_page");
    exit;
}

// if the isPatient boolean variable is not set then redirect to the selection screen for determining patient/doctor status
if(!isset($_SESSION["isPatient"])){
    header("location: index.php");
}

// create local varibales to store data about the user
$dob = $fname = $lname = $email = $password = "";
$error = false;


// handles form input, validates it, and stores it in previously created local variables
if (isset($_POST) && !empty($_POST)) {
    if(empty(trim($_POST["fname"]))){
        $error = true;
        $fname = "Please enter a first name.";
    } else {
        $fname = trim($_POST["fname"]);
    }

    if(empty(trim($_POST["lname"]))){
        $error = true;
        $lname = "Please enter a last name.";
    } else {
        $lname = trim($_POST["lname"]);
    }
    if ($_SESSION["isPatient"]){
        if(empty(trim($_POST["dob"]))){
            $error = true;
            $dob = "Please enter a date of birth.";
        } else {
            $dob = trim($_POST["dob"]);
        }
    }
    
    if(empty(trim($_POST["email"]))){
        $error = true;
        $email = "Please enter a email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if(empty(trim($_POST["password"]))){
        $error = true;
        $password = "Please enter a password.";
    } else {
        $password = trim($_POST["password"]);
    }

    $sql = "";
    if(!$error){
        // dynamically create sql command for either patient or doctor
        if ($_SESSION["isPatient"]){
            $sql = "SELECT * FROM patient WHERE p_email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
        } else{
            $sql = "SELECT * FROM doctor WHERE d_email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
        }

        // prepare and execute the sql command
        $stmt = mysqli_prepare($conn, $sql);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                // fetches data from sql query and stashes them in the gloabl session varibale
                $_SESSION["loggedin"] = true;
                $_SESSION["name"] = $row['first_name'] . " " . $row['last_name'];
                $_SESSION['h_id'] = $row['h_id'];

                if ($_SESSION["isPatient"]){
                    $_SESSION["id"] = $row['p_id'];
                    $_SESSION["email"] = $row['p_email'];
                    $_SESSION['dob'] = $row['DOB'];
                    $_SESSION["d_id"] = $row['d_id'];
                } else {
                    $_SESSION["id"] = $row['d_id'];
                    $_SESSION["email"] = $row['d_email'];
                }
                // redirects upon successfully creating an account
                header("location: ../profile_page");
                exit;
            } else{
                echo "Invalid information entered";
            }
        } else {
            echo "Invalid information entered";
        }
    } else {
        echo "Invalid information entered";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>HowdyHealthy</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class=form-card>
        <div class="header">
            <h2>Sign In to HowdyHealthy</h2>
        </div>

        <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
            <div class="input-group">
                <label>First Name</label>
                <input type="text" name="fname">
            </div>
            <div class="input-group">
                    <label>Last Name</label>
                    <input type="text" name="lname">
            </div>
            <?php if ($_SESSION['isPatient']) { ?>
                <div class="input-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob">
                </div>
            <?php } ?>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" >
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" >
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login">Login</button>
            </div>
            <p>
                Don't have an account? <a href="signup.php">Sign Up Here!</a>
            </p>
        </form>
    </div>
</body>

</html>