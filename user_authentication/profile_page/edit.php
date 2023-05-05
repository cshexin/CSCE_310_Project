<?php

include('../../config/db_connect.php');

if(!isset($_SESSION)) { session_start(); }

if (!isset($_SESSION["id"])) {
    header("location: ../signin_page");
    exit;
} 

$id = 0;
$dob = $fname = $lname = $email = $password = "";
$error = false;
$sql = "";
$doctor_id = 1;
$hospita_id = 1;
$doctorsSelection = array();
$hospitalSelection = array();
$doctorsToHospital = array();

$nameData = explode(" ", $_SESSION['name']);
$fname = $nameData[0];
$lname = $nameData[1];
$email = $_SESSION['email'];
$id = $_SESSION['id'];
$hospital_id = $_SESSION['h_id'];
if($_SESSION['isPatient']){
    $dob = $_SESSION['dob'];
    $doctor_id = $_SESSION['d_id'];
}

if ($_SESSION["isPatient"]){
    $sql = "SELECT * FROM doctor";
} else {
    $sql = "SELECT * FROM hospital";
}

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


if ($_SESSION["isPatient"]){
    while ($row = mysqli_fetch_assoc($result)) {
        $doctorsSelection[$row['d_id']] = "Dr. " . $row['first_name'] . " " . $row["last_name"];
        $doctorsToHospital[$row['d_id']] = $row['h_id'];
    }
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $hospitalSelection[$row['h_id']] = $row['h_name'];
    }
}



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

    if ($_SESSION["isPatient"]){
        $doctor_id = $_POST['doctor'];
        $hospital_id = $doctorsToHospital[$doctor_id];
    } else {
        $hospital_id = $_POST['hospital'];
    }

    if(!$error){
        echo $fname . " " . $lname . " " . $password . " " .  $email . " " . $id;

        if($_SESSION['isPatient']){
            $sql = "UPDATE patient SET first_name = '$fname', last_name = '$lname', DOB = '$dob', d_id = $doctor_id, h_id = $hospital_id, p_password = $password, p_email = '$email' WHERE p_id = $id";
        } else {
            $sql = "UPDATE doctor SET first_name = '$fname', last_name = '$lname', h_id = $hospital_id, d_password = $password, d_email = '$email' WHERE d_id = $id";
        }
        
        // TODO: ADD CHECK TO MAKE SURE EMAILS ARE NOT THE SAME
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) != 1){
            echo "Query didn't go through";
        } else {
            $_SESSION["name"] = $fname . " " . $lname;
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION['h_id'] = $hospital_id;

            if($_SESSION['isPatient']){
                $_SESSION["dob"] = $dob;
                $_SESSION["d_id"] = $doctor_id;
            }
    
            header("location: index.php");
            exit;
        }
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
        <?php if ($_SESSION['isPatient']) { ?>
            <div class="input-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="2023-04-30">
            </div>
            <div class="input-group">
                <label>Primary Doctor</label>
                <select class="sel" name="doctor">
                    <?php foreach ($doctorsSelection as $id => $name) { ?>
                        <option value="<?php echo $id; ?>" <?php if ($id == $doctor_id) echo "selected"; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        <?php } else { ?>
            <div class="input-group">
                <label>Primary Hospital</label>
                <select class="sel" name="hospital">
                    <?php foreach ($hospitalSelection as $id => $name) { ?>
                        <option value="<?php echo $id; ?>" <?php if ($id == $hospital_id) echo "selected"; ?>>
                            <?php echo $name; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        <?php } ?>
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
            <a href="index.php">Back to Profile</a>
        </div>

    </form>
  </body>
</html>