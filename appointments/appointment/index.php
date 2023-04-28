<?php
    // connect to database
    include("../../config/db_connect.php");
    
    $app_id = $_POST['app_id_button'];
    // get appointment id
    
    // wrtie query for all appointments
    $sql = "SELECT * FROM appointment WHERE app_id = $app_id";

    // make query & get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $datas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $finalTime = $datas[0]['app_date'] . "T" . $datas[0]['app_time'];
    $patientid = $datas[0]['p_id'];
    $doctorid = $datas[0]['d_id'];

    $sqldoctor = "SELECT last_name, first_name FROM doctor where d_id = $doctorid";
    $resultdoct = mysqli_query($conn, $sqldoctor);
    $dataDoctor = mysqli_fetch_all($resultdoct, MYSQLI_ASSOC);
    $doctorName = $dataDoctor[0]['first_name'] . "" . $dataDoctor[0]['last_name'] . ", MD";

    $sqlpatient = "SELECT last_name, first_name FROM patient where p_id = $patientid";
    $resultpatient = mysqli_query($conn, $sqlpatient);
    $datapatient = mysqli_fetch_all($resultpatient, MYSQLI_ASSOC);
    $patientName = $datapatient[0]['first_name'] . "" . $datapatient[0]['last_name'];

    // free result from memory
    mysqli_free_result($result);
    mysqli_free_result($resultdoct);
    mysqli_free_result($resultpatient);

    mysqli_close($conn);

    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Appointment Page</title>
        <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <h1>Appointment Information</h1>
        <form id="appointment_detail">
            <div id="appointment_text">
                <label for="dname"> Doctor Name:</label>
                <input type="text" id="dname" name="dname" value="<?php echo $doctorName; ?>"> <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname" value="<?php echo $patientName; ?>"> <br> <br>
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