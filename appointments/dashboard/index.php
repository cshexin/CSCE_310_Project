<?php
    session_start();
    // connect to database
    include("../../config/db_connect.php");
    // boolean variable to know if user is a patient or a doctor
    $patientUser = $_SESSION['isPatient'];

    $userid = $_SESSION['id'];

    // wrtite query for patients
    if($patientUser === true){
        $sql = "SELECT * FROM appointment WHERE p_id = $userid";
        $sqluser = "SELECT first_name, last_name FROM patient WHERE p_id = $userid";
    } else { // or write query for doctors
        $sql = "SELECT * FROM appointment WHERE d_id = $userid";
        $sqluser = "SELECT first_name, last_name FROM doctor WHERE d_id = $userid";
    }
    // make query & get result
    $result = mysqli_query($conn, $sql);
    $resultuser = mysqli_query($conn, $sqluser);

    // fetch the resulting rows as an array
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $datauser = mysqli_fetch_all($resultuser, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
    mysqli_free_result($resultuser);

    mysqli_close($conn);
    // get the first and last name of user
    $userName = $datauser[0]['first_name'] . ''. $datauser[0]['last_name'];
    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

?>

<!DOCTYPE html>
<html lang=eng>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <h1 id="dashboard">Dashboard</h1>
        <div id="dashboard-title">
            <h3> Hello, <?php echo $userName;?></h3>
            <form action="create.php" method="post">
                <button type="input" id="add_app" name="add_app" value='<?php echo $userid; ?>'>
                    <p>Schedule an Appointment<p>
                </button>
            </form>
        </div>
        <div id="patient-appointments">
            <?php foreach($data as $d): ?>
            <div>
                <a href="details.php?id=<?php echo $d['app_id']?>">
                    <button type="button" id="appointment-button">
                        Appointment
                    </button>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>