<?php
    // connect to database
    include("../../config/db_connect.php");

    $createPatientId = $_POST['add_app'];

    // wrtite query for patients
    $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $createPatientId";
    $sqldoctor = "SELECT d_id, last_name, first_name FROM doctor";
    // make query & get result
    $resultPatient = mysqli_query($conn, $sqlpatient);
    $resultDoctor = mysqli_query($conn, $sqldoctor);
    // fetch the resulting rows as an array
    $datapatient = mysqli_fetch_all($resultPatient, MYSQLI_ASSOC);
    $datadoctor = mysqli_fetch_all($resultDoctor, MYSQLI_ASSOC);

    $createpatientName = $datapatient[0]['first_name'] . ''. $datapatient[0]['last_name'];
    $createMeetingTime = $createDoctorId = "";
    if(isset($_POST['app_id_button'])){
        $p_id = mysqli_real_escape_string($conn, $_POST['add_app']);
        $createMeetingTime = $_POST['meeting-time'];
        $createDoctorData = $_POST['dname'];
        $createSplitDoctorData = explode(",", $createDoctorData);
        $d_id = mysqli_real_escape_string($conn, $createSplitDoctorData[0]);
        // get the date and time of the meeting the user eneterd
        $createSplitMeetingTime = explode("T", $createMeetingTime);
        $app_date = $createSplitMeetingTime[0];
        $app_time = $createSplitMeetingTime[1];

        // create sql
        $sql_insert = "INSERT INTO appointment(app_id, app_date, app_time, p_id, d_id) VALUES ('','$app_date','$app_time', '$p_id', '$d_id')";
        // save to db
        if(mysqli_query($conn, $sql_insert)){
            header('Location: index.php');
        } else {
            echo 'query error: ', mysqli_error($conn);
        }
    }
    // free result from memory
    mysqli_free_result($resultPatient);
    mysqli_free_result($resultDoctor);
    // clost connection
    mysqli_close($conn);

    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);
?>

<!DOCTYPE html>
<html lang=eng>
    <head>
        <title>Appointment Page</title>
        <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <h1>Enter Appointment Information</h1>
        <form id="appointment_detail" method="POST">
            <div id="appointment_text">
                <label for="dname"> Doctor Name:</label>
                <input list="dnames" id="dname" name="dname">
                <datalist id = "dnames">
                    <?php foreach($datadoctor as $doctor): ?>
                        <option value="<?php echo $doctor['d_id'] . "," .$doctor['first_name'] . "" .  $doctor['last_name']; ?>">
                    <?php endforeach; ?>
                </datalist>
                
                <input type="hidden" id="add_app" name="add_app" value="<?php echo $createPatientId; ?>" readonly>
                <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname" value="<?php echo $createpatientName; ?>" readonly> <br> <br>
                <label for="meeting-time">Date and Time: </label>
                <input type="datetime-local" id="meeting-time" name="meeting-time"> <br> <br>
            </div>
            <div id="appointment_button">
                <button type="submit" name="app_id_button" value="<?php echo $createPatientId; ?>">Submit</button>
            </div>
        <form>
    </body>
</html>