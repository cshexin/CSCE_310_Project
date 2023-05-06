<?php

/*

Description: Script to delete the user from the database 
Author: Andrew Mao

*/

// connect to database
include('../../config/db_connect.php');

// checks if the user session has been started or not
if (!isset($_SESSION)) {
    session_start();
}

// checks if the user logged in and has an id, if not then redirect to sign in
if (!isset($_SESSION["id"])) {
    header("location: ../signin_page");
} else {
    // fetches user data from session global variable
    $id = $_SESSION['id'];
    $isPatient = $_SESSION['isPatient'];

    $sql = "";
    // creates sql command to delete user
    if ($isPatient) {
        $sql = "DELETE FROM patient WHERE p_id = $id";
    } else {
        $sql = "DELETE FROM doctor WHERE d_id = $id";
    }
    // executes sql to delete user
    $stmt = mysqli_prepare($conn, $sql);
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) != 1) {
            echo "Delete query failed";
        } else {
            echo "Deleted account";
            // Delete related comments
            // $sql = "DELETE FROM comment WHERE ";
            // if ($isPatient) {
            //     $sql .= "p_id = $id";
            // } else {
            //     $sql .= "d_id = $id";
            // }
            // mysqli_query($conn, $sql);

            // // Delete related posts
            // $sql = "DELETE FROM post WHERE ";
            // if ($isPatient) {
            //     $sql .= "p_id = $id";
            // } else {
            //     $sql .= "d_id = $id";
            // }
            // mysqli_query($conn, $sql);

            // // Delete related appointments
            // $sql = "DELETE FROM appointment WHERE ";
            // if ($isPatient) {
            //     $sql .= "p_id = $id";
            // } else {
            //     $sql .= "d_id = $id";
            // }
            // mysqli_query($conn, $sql);

            // redirect to logout and reset session variables
            header("location: ../signin_page/logout.php");
            exit;
        }
    } else {
        echo "Delete query failed";
    }
}
?>
