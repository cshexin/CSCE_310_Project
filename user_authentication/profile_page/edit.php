
<?php
    // connect database
include('../../config/db_connect.php');

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$id = 0;
$dob = $fname = $lname = $email = $password = "";
$error = false;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if(empty(trim($_POST["dob"]))){
        $error = true;
        $dob = "Please enter a date of birth.";
    } else {
        $dob = trim($_POST["dob"]);
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

    if(!$error){
        $sql = "UPDATE patient SET first_name = '$fname', last_name = '$lname', p_email = '$email', p_password = '$password', DOB = '$dob' WHERE id = '$id'";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        header("location: index.php");
        exit;
    }
}

if (!isset($_SESSION["name"])) {
    header("location: ../signin_page");
} else {
    $nameData = explode(" ", $_SESSION['name']);
    $fname = $nameData[0];
    $lname = $nameData[1];
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM patient WHERE p_email = '$email' AND first_name = '$fname' AND last_name = '$lname'";
    $stmt = mysqli_prepare($conn, $sql);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION["loggedin"] = true;
            $id = $_SESSION["id"] = $row['p_id'];
            $_SESSION["name"] = $row['first_name'] . " " . $row['last_name'];
            $_SESSION["email"] = $row['p_email'];
            $dob = $_SESSION["dob"] = $row['DOB'];
            $password = $_SESSION["password"] = $row['p_password'];
        } else{
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
    <title>Edit Profile page</title>
    <?php include('../../header/header.php'); ?>
    
    <div class="header">
        <h2>EDIT PROFILE PAGE</h2>
    </div>

    <form method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
        <div class="input-group">
            <label>First Name</label>
            <input type="text" name="fname"  value="<?php echo isset($fname) ? $fname: ''; ?>">
        </div>
        <div class="input-group">
                <label>Last Name</label>
                <input type="text" name="lname"  value="<?php echo isset($lname) ? $lname : ''; ?>">
        </div>
        <div class="input-group">
            <label>Date of Birth</label>
            <input type="date" name="dob"  value="<?php echo isset($dob) ? $dob : ''; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email"  value="<?php echo isset($email) ? $email : ''; ?>" >
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password"  value="<?php echo isset($password) ? $password : ''; ?>" >
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="update">Update Profile</button>
        </div>

    </form>
  </body>
</html>