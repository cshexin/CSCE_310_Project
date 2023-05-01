<?php


// connect database
include('../../config/db_connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION["isPatient"])){
    header("location: index.php");
}


$dob = $fname = $lname = $email = $password = "";
$error = false;

// TODO: ADD BETTER ERROR CHECKING
// TODO: SUPPORT DOCTOR VS PATIENT LOG IN

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
        if ($_SESSION["isPatient"]){
            $sql = "INSERT INTO patient (first_name, last_name, DOB, h_id, d_id ,p_password, p_email) VALUES ('$fname', '$lname', '$dob', 1, 1, '$password', '$email')";
        } else {
            $sql = "INSERT INTO doctor (first_name, last_name, h_id ,d_password, d_email) VALUES ('$fname', '$lname', 1, '$password', '$email')";
        }
        if(mysqli_query($conn, $sql)){
            if(mysqli_affected_rows($conn) > 0){

                $_SESSION["name"] = $fname . " " . $lname;
                $_SESSION["email"] = $email;
                
                if ($_SESSION["isPatient"]){
                    $sql = "SELECT * FROM patient WHERE p_email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
                } else {
                    $sql = "SELECT * FROM doctor WHERE d_email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
                }
                
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $_SESSION["loggedin"] = true;

                if ($_SESSION["isPatient"]){
                    $_SESSION["id"] = $row['p_id'];
                    $_SESSION['dob'] = $row['DOB'];
                } else {
                    $_SESSION["id"] = $row['d_id'];
                }
                

                header("location: ../profile_page");
                exit();
            } else {
              echo 'querry error: No rows were affected';
            }
        } else {
            echo "querry error";
        }
        
    } else{
        echo "Something went wrong";
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <title>Sign Up to HowdyHealthy</title>
</head>

<body>
    <div class="header">
        <h2>Register</h2>
    </div>

    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        <div class="input-group">
            <label>First Name</label>
            <input type="text" name="fname" value="John">
        </div>
        <div class="input-group">
                <label>Last Name</label>
                <input type="text" name="lname" value="Doe">
        </div>
        <?php if ($_SESSION['isPatient']) { ?>
            <div class="input-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="2023-04-30">
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
            <button type="submit" class="btn" name="register">Register</button>
        </div>
        <p>
            Already a member? <a href="signin.php">Sign in</a>
        </p>
    </form>
</body>

</html>