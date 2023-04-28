<?php
    // connect to database
    include("../../config/db_connect.php");

    $createPatientId = $_POST['add_app'];

    $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $createPatientId";

    $resultPatient = mysqli_query($conn, $sqlpatient);

    $datapatient = mysqli_fetch_all($resultPatient, MYSQLI_ASSOC);

    mysqli_free_result($resultPatient);

    mysqli_close($conn);

    $createpatientName = $datapatient[0]['first_name'] . ''. $datapatient[0]['last_name'];
    
    $createDoctorName = $createMeetingTime = "";
    // find p_id, last_name, first_

    if(isset($_POST['submit'])){
        $createDoctorName = $_POST['dname'];
        $createMeetingTime = $_POST['meeting-time'];

        $createSplitMeetingTime = explode("T", $createMeetingTime);
        $createMeetingDate = $createSplitDoctorName[0];
        $createMeetingClock = $createSplitDoctorName[0];
    }

    // find matching p_id/d_id with names

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
                <input type="text" id="dname" name="dname"> <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname" value="<?php echo $createpatientName; ?>" readonly> <br> <br>
                <label for="meeting-time">Date and Time: </label>
                <input type="datetime-local" id="meeting-time" name="meeting-time"> <br> <br>
            </div>
        <form>
        <div id="appointment_button">
            <button type="submit" name="submit" value="submit">Submit</button>
            <button type="button">Edit</button>
            <button type="button" onclick()="cancelExecute()">Cancel</button>
        </div>
    </body>
</html>