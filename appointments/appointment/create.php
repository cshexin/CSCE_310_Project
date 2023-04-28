<?php
    // connect to database
    include("../../config/db_connect.php");

    $createPatientId = $_POST['add_app'];

    // wrtite query for patients
    $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $createPatientId";
    $sqldoctor = "SELECT last_name, first_name FROM doctor";
    // make query & get result
    $resultPatient = mysqli_query($conn, $sqlpatient);
    $resultDoctor = mysqli_query($conn, $sqldoctor);
    // fetch the resulting rows as an array
    $datapatient = mysqli_fetch_all($resultPatient, MYSQLI_ASSOC);
    $datadoctor = mysqli_fetch_all($resultDoctor, MYSQLI_ASSOC);

    $createpatientName = $datapatient[0]['first_name'] . ''. $datapatient[0]['last_name'];
    $createMeetingTime = $createDoctorId = "";
    if(isset($_POST['submit'])){
        $p_id = $_POST['add_app'];
        $createMeetingTime = $_POST['meeting-time'];
        $createDoctorName = $_POST['dname'];
        $createSplitDoctorName = explode(" ", $createDoctorName);
        $createDoctorFirstName = $createSplitDoctorName[0];
        $createDoctorLastName = $createSplitDoctorName[1];

        // echo $createDoctorFirstName . '<br />';
        // echo $createDoctorLastName . '<br />';


        $sqldoctorid = "SELECT d_id FROM doctor WHERE first_name = $createDoctorFirstName";
        $resultDoctorId = mysqli_query($conn, $sqldoctorid);
        $datadoctorid = mysqli_fetch_all($resultDoctorId, MYSQLI_ASSOC);
        print_r($datadoctorid);

        // get the date and time of the meeting the user eneterd
        $createSplitMeetingTime = explode("T", $createMeetingTime);
        $app_date = $createMeetingTime[0];
        $app_time = $createMeetingTime[0];

        mysqli_free_result($resultDoctorId);
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
                        <option value="<?php echo $doctor['first_name'] . "" .  $doctor['last_name']; ?>">
                    <?php endforeach; ?>
                </datalist> <br> <br>
                <label for="pname"> Patient ID:</label>
                <input type="text" id="add_app" name="add_app" value="<?php echo $createPatientId; ?>" readonly>
                <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname" value="<?php echo $createpatientName; ?>" readonly> <br> <br>
                <label for="meeting-time">Date and Time: </label>
                <input type="datetime-local" id="meeting-time" name="meeting-time"> <br> <br>
            </div>
            <div id="appointment_button">
                <button type="submit" name="submit" value="submit">Submit</button>
                <button type="button" onclick()="cancelExecute()">Cancel</button>
            </div>
        <form>
    </body>
</html>