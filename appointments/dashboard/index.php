<?php

    // connect to database
    include("../../config/db_connect.php");
    $patientid = 1;

    // wrtite query for patients
    $sql = "SELECT * FROM appointment WHERE p_id = $patientid";
    $sqlpatient = "SELECT first_name, last_name FROM patient WHERE p_id = $patientid";
    // make query & get result
    $result = mysqli_query($conn, $sql);
    $resultPatient = mysqli_query($conn, $sqlpatient);

    // fetch the resulting rows as an array
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $datapatient = mysqli_fetch_all($resultPatient, MYSQLI_ASSOC);

     // free result from memory
    mysqli_free_result($result);
    mysqli_free_result($resultPatient);

    mysqli_close($conn);
    $patientName = $datapatient[0]['first_name'] . ''. $datapatient[0]['last_name'];
    $cssFile = 'index.css';
    $cssContent = file_get_contents($cssFile);
    $hash = md5($cssContent);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="index.css?version=<?php echo $hash; ?>">
    </head>
    <body>
        <?php include('../../header/header.php'); ?>
        <h1>Dashboard</h1>
        <div id="dashboard-title">
            <h2> Hello, <?php echo $patientName;?></h2>
            <form action="../appointment/create.php">
                <button type="submit" id="add_app" name="add_app">Schedule an Appointment</button>
            </form>
        </div>
        <div id="patient-appointments">
            <?php foreach($data as $d): ?>
            <div>
                <form action="../appointment/index.php" method="post">
                    <button type="submit" id="app_id" name="app_id_button" value="<?php echo $d['app_id']; ?>">Appointment</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>