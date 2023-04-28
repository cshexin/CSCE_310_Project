<?php
    // connect to database
    include("../../config/db_connect.php");

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
        <h1>Enter Appointment Information</h1>
        <form id="appointment_detail">
            <div id="appointment_text">
                <label for="dname"> Doctor Name:</label>
                <input type="text" id="dname" name="dname"> <br> <br>
                <label for="pname"> Patient Name:</label>
                <input type="text" id="pname" name="pname"> <br> <br>
                <label for="meeting-time">Date and Time: </label>
                <input type="datetime-local" id="meeting-time" name="meeting-time"> <br> <br>
            </div>
            <div id="appointment_button">
                <button type="submit" name="submit" value="submit">Submit</button>
                <button type="button">Edit</button>
                <button type="button" onclick()="cancelExecute()">Cancel</button>
            </div>
        <form>
    </body>
</html>