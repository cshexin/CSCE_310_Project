<?php
/*

Description: the landing page to select what user type you are
Author: Andrew Mao

*/
    // starts the session to access $_SESSION global variable
    session_start();

    // checks if the form has been submitted and changes the isPatient global boolean
    if(isset($_POST['is_patient'])) {
        if($_POST['is_patient'] == 'true') {
            $_SESSION['isPatient'] = true;
        } else {
            $_SESSION['isPatient'] = false;
        }
        // redirects to the sign in page
        header("location: ../signin_page/signin.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class=form-card>
        <h1 class="header">Welcome to HowdyHealthy! First select if you are a doctor or a patient.</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label>
                <input type="radio" name="is_patient" value="false" <?php if(isset($_SESSION['isPatient']) && $_SESSION['isPatient'] == true) echo "checked"; ?>>
                Doctor
            </label>
            <br>
            <label>
                <input type="radio" name="is_patient" value="true" <?php if(!isset($_SESSION['isPatient']) || $_SESSION['isPatient'] == false) echo "checked"; ?>>
                Patient
            </label>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
