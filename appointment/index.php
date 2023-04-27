<?php
    // edit - only change date and time
    // cancel - delete the whole appointment
    // patient can have many appointments

    // connect to database
    include("../config/db_connect.php");

    // patientid = $_GET['patientid'];
    // get patient id
    $patientid = 1;
    // or get doctor id
    
    // wrtie query for all appointments
    $sql = "SELECT app_date, app_time FROM appointment WHERE p_id = $patientid";
    $sqlother = "SELECT first_name, last_name FROM patient WHERE p_id = $patientid";

    // make query & get result
    $result = mysqli_query($conn, $sql);
    $resultother = mysqli_query($conn, $sqlother);

    // fetch the resulting rows as an array
    $datas = mysqli_fetch_all($result, MYSQLI_ASSOC);


    // free result from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

    foreach($datas as $data){
        $finalTime = $data['app_date'] . "T" . $data['app_time'];
    }

    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

    // $errors = array('dname'=>'', 'pname'=>'', 'meeting-time'=>'');
    // $dname = $pname = $meetingtime = '';

    // if(isset($_POST['submit'])){
    //     if(empty($_POST['dname'])){
    //         $errors['dname'] = 'A doctor name is required';
    //     } else {
    //         $dname = $_POST['dname'];
    //     }

    //     if(empty($_POST['pname'])){
    //         $errors['pname'] = 'A patient name is required';
    //     } else {
    //         $pname = $_POST['pname'];
    //     }

    //     if(empty($_POST['meeting-time'])){
    //         $errors['meeting-time'] = 'A meeting time is required';
    //     } else {
    //         $meetingtime = $_POST['meeting-time'];
    //     }
    // }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Appointment Page</title>
        <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../header/header.php'); ?>
        <h1>Appointment A</h1>
        <form id="appointment_detail">
            <div id="appointment_text">
                <label for="dname"> Doctor Name:</label>
                <input type="text" id="dname" name="dname"> <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname"> <br> <br>
                <label for="meeting-time">Date and Time: </label>
                <input type="datetime-local" id="meeting-time" name="meeting-time" value="<?php echo $finalTime; ?>"> <br> <br>
            </div>
            <div id="appointment_button">
                <button type="submit" name="submit" value="submit">Submit</button>
                <button type="button">Edit</button>
                <button type="button" onclick()="cancelExecute()">Cancel</button>
            </div>
        <form>
    </body>
</html>