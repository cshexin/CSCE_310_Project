<?php
    session_start();
    include("../../config/db_connect.php");
    
    // boolean variable to know if user is a patient or a doctor
    $patientUser = $_SESSION['user'];

    if(isset($_POST['delete'])){
        $id_to_modify = mysqli_real_escape_string($conn, $_POST['id_to_modify']);

        $sql = "DELETE FROM appointment WHERE app_id = $id_to_modify";

        if(mysqli_query($conn, $sql)){
            // success
            header("Location: index.php");
        } else {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    if(isset($_POST['submit'])){
        $id_to_modify = mysqli_real_escape_string($conn, $_POST['id_to_modify']);
        $submitMeetingTime =  $_POST['meeting-time'];
        if($patientUser === true){
            $submitDoctorData =  $_POST['dname'];
            $submitSplitDoctorData = explode(",", $submitDoctorData);
            $d_id = mysqli_real_escape_string($conn, $submitSplitDoctorData[0]);
        } else {
            $submitPatientData =  $_POST['pname'];
            $submitSplitPatientData = explode(",", $submitPatientData);
            $p_id = mysqli_real_escape_string($conn, $submitSplitPatientData[0]);
        }

        // get the date and time of the meeting the user eneterd
        $submitSplitMeetingTime = explode("T", $submitMeetingTime);
        $app_date = mysqli_real_escape_string($conn, $submitSplitMeetingTime[0]);
        $app_time = mysqli_real_escape_string($conn, $submitSplitMeetingTime[1]);

        if($patientUser === true){
            $sqlupdate = "UPDATE appointment SET app_date = '$app_date', app_time = '$app_time', d_id = '$d_id' WHERE app_id = $id_to_modify";
        } else {
            $sqlupdate = "UPDATE appointment SET app_date = '$app_date', app_time = '$app_time', p_id = '$p_id' WHERE app_id = $id_to_modify";
        }

        if(mysqli_query($conn, $sqlupdate)){
            // success
            header("Location: index.php");
        } else {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }

    }


    // check GET request id param
    if(isset($_GET['id'])){

        $app_id = mysqli_real_escape_string($conn, $_GET['id']);
    
        // make sql to retrieve appointment detail
        $sql = "SELECT * FROM appointment WHERE app_id = $app_id";

        // get the query result
        $result = mysqli_query($conn, $sql);

        // fetch result in array format; want 1 row
        $appointment_info = mysqli_fetch_assoc($result);

        $time = $appointment_info['app_date'] . "T" . $appointment_info['app_time'];

        $p_id = $appointment_info['p_id'];
        $d_id = $appointment_info['d_id'];

        
        // make sql to retrieve patient and doctor first and last name
        $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $p_id";
        $sqldoctor = "SELECT first_name, last_name FROM doctor WHERE d_id = $d_id";
        if($patientUser === true){
            $sqllist = "SELECT d_id, first_name, last_name FROM doctor";
        } else {
            $sqllist = "SELECT p_id, first_name, last_name FROM patient";
        }

        // get the query result
        $resultpatient = mysqli_query($conn, $sqlpatient);
        $resultdoctor = mysqli_query($conn, $sqldoctor);
        $resultlist = mysqli_query($conn, $sqllist);

        // fetch result
        $patient_info = mysqli_fetch_assoc($resultpatient);
        $doctor_info = mysqli_fetch_assoc($resultdoctor);
        $datalist = mysqli_fetch_all($resultlist);

        $patientName = $patient_info['first_name'] . '' . $patient_info['last_name'];
        $doctorName = $doctor_info['first_name'] . '' . $doctor_info['last_name'] . ', MD';

        mysqli_free_result($resultlist);
        mysqli_free_result($resultpatient);
        mysqli_free_result($resultdoctor);
        mysqli_free_result($result);
        mysqli_close($conn);
    
    }

    $cssFile = 'details.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);
?>


<!DOCTYPE html>
<html lang=eng>
    <head>
        <title>Appointment Details</title>
        <link rel="stylesheet" type="text/css" href="details.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <div id="detail">
            <h1>Appointment Information</h1>
            <?php if($appointment_info): ?>
                <form action="details.php" method="POST">
                    <?php if($patientUser === true): ?>
                        <label for="doctor_name"> Doctor Name: </label>
                        <input type="text" id="dname" name="dname" value="<?php echo $doctorName ?>" readonly>
                        <span hidden="hidden" id="showdoctorlist">
                            <input list="dnames" id="dname" name="dname">
                            <datalist id = "dnames">
                                <?php foreach($datalist as $doctor): ?>
                                    <option value="<?php echo $doctor[0] . "," . $doctor[1] . "" .  $doctor[2]; ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </span>
                        <br><br>
                        <label for="patient_name"> Patient Name: </label>
                        <input type="text" id="pname" name="pname" value="<?php echo $patientName; ?>" readonly>
                        <br><br>
                    <?php else: ?>
                        <label for="doctor_name"> Doctor Name:</label>
                        <input type="text" id="dname" name="dname" value="<?php echo $doctorName; ?>" readonly>
                        <br><br>
                        <label for="patient_name"> Patient Name:</label>
                        <input type="text" id="pname" name="pname" value="<?php echo $patientName; ?>" readonly>
                        <span hidden="hidden" id="showpatientlist">
                            <input list="pnames" id="pname" name="pname">
                            <datalist id="pnames">
                                <?php foreach($datalist as $patient): ?>
                                    <option value="<?php echo $patient[0] . "," . $patient[1] . "" .  $patient[2]; ?>">
                                <?php endforeach; ?>
                            </datalist>
                        </span>
                        <br><br>
                    <?php endif; ?>
                    <label for="meeting-time"> Time: </label>
                    <input type="datetime-local" id="meeting-time" name="meeting-time" value="<?php echo $time; ?>" readonly="readonly">
                    <br><br>

                <!-- DELETE AND UPDATE APPOINTMENT -->
                    <input type="hidden" name="id_to_modify" value="<?php echo $appointment_info['app_id']; ?>">
                    <input type="button" id="editButton" name="editButton" value="Edit">
                    <input type="submit" id="submitButton" name="submit" value="Submit">
                    <input type="submit" id="cancelButton" name="delete" value="Cancel">
                </form>

            <?php else: ?>
                <h5>No Appointment Exists! </h5>
            <?php endif; ?>
        </div>
    </body>
    <?php if($patientUser === true): ?>
        <script src="new.js"></script>
    <?php else: ?>
        <script src="new2.js"></script>
    <?php endif; ?>
</html>