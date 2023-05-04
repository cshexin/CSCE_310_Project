<?php
    session_start();
    // connect to database
    include("../../config/db_connect.php");

    // recieves the id of the user
    $createUserId = $_POST['add_app'];
    // boolean variable to know if user is a patient or a doctor
    $patientUser = $_SESSION['isPatient'];

    // wrtite query for patients
    if($patientUser === true){
        $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $createUserId";
        $sqldoctor = "SELECT d_id, last_name, first_name FROM doctor";
    } else {
        $sqldoctor = "SELECT first_name, last_name FROM doctor WHERE d_id = $createUserId";
        $sqlpatient = "SELECT p_id, last_name, first_name FROM patient";
    }

    // make query & get result
    $resultPatient = mysqli_query($conn, $sqlpatient);
    $resultDoctor = mysqli_query($conn, $sqldoctor);

    // fetch the resulting rows as an array
    $datapatient = mysqli_fetch_all($resultPatient, MYSQLI_ASSOC);
    $datadoctor = mysqli_fetch_all($resultDoctor, MYSQLI_ASSOC);
    if($patientUser === true){
        $createpatientName = $datapatient[0]['first_name'] . ''. $datapatient[0]['last_name'];
        $createMeetingTime = $createDoctorId = "";
    } else {
        $createdoctorName = $datadoctor[0]['first_name'] . '' . $datadoctor[0]['last_name'];
        $createMeetingTime = $createPatientId = "";
    }

    if(isset($_POST['app_id_button'])){
        
        if($patientUser === true){
            $p_id = mysqli_real_escape_string($conn, $_POST['add_app']);
            $createMeetingTime = $_POST['meeting-time'];
            $createDoctorData = $_POST['dname'];
            $createSplitDoctorData = explode(",", $createDoctorData);
            $d_id = mysqli_real_escape_string($conn, $createSplitDoctorData[0]);
        
        } else {
            $d_id = mysqli_real_escape_string($conn, $_POST['add_app']);
            $createMeetingTime = $_POST['meeting-time'];
            $createPatientData = $_POST['pname'];
            $createSplitPatientData = explode(",", $createPatientData);
            $p_id = mysqli_real_escape_string($conn, $createSplitPatientData[0]);
        }

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

    $cssFile = 'create.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);
?>

<!DOCTYPE html>
<html lang=eng>
    <head>
        <title>Appointment Page</title>
        <link rel="stylesheet" type="text/css" href="create.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <div id="info">
            <h1>Enter Appointment Information</h1>
            <form id="appointment_detail" method="POST">
                <div id="appointment_text">
                    <?php if($patientUser === true): ?>
                        <p id="enter">Please Enter Doctor Name and Date and Time: </p>
                        <label for="dname"> Doctor Name:</label>
                        <select id="dname" name="dname">
                            <?php foreach($datadoctor as $doctor): ?>
                                <option value="<?php echo $doctor['d_id'] . "," . $doctor['first_name'] . "" .  $doctor['last_name']; ?>"> 
                                    <?php echo trim($doctor['first_name']) . " " .  trim($doctor['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        <input type="hidden" id="add_app" name="add_app" value="<?php echo $createUserId; ?>" readonly>
                        <br> <br>
                        <label for="pname"> Patient Name:</label>
                        <input type="text" id="pname" name="pname" value="<?php echo $createpatientName; ?>" readonly>
                        <br> <br>
                    <?php else: ?>
                        <p id="enter">Please Enter Patient Name and Date and Time: </p>
                        <input type="hidden" id="add_app" name="add_app" value="<?php echo $createUserId; ?>" readonly>
                        <br><br>
                        <label for="dname"> Doctor Name:</label>
                        <input type="text" id="dname" name="dname" value="<?php echo $createdoctorName; ?>" readonly>
                        <br><br>
                        <label for="pname"> Patient Name:</label>
                        <select id="pname" name="pname">
                            <?php foreach($datapatient as $patient): ?>
                                <option value="<?php echo $patient['p_id'] . "," . $patient['first_name'] . "" .  $patient['last_name']; ?>">
                                    <?php echo trim($patient['first_name']) . " " .  trim($patient['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                        <br><br>
                    <?php endif; ?>
                    <label for="meeting-time">Date and Time: </label>
                    <input type="datetime-local" id="meeting-time" name="meeting-time" min="" required> <br> <br>
                </div>
                <div id="appointment_button">
                    <button type="submit" id="submit-button" name="app_id_button" value="<?php echo $createUserId; ?>">Submit</button>
                </div>
            <form>
        </div>
    </body>
    <script src="time.js"></script>
</html>