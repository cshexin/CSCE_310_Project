<?php
include('../../config/db_connect.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("location: ../signin_page");
} else {
    $id = $_SESSION['id'];
    $isPatient = $_SESSION['isPatient'];

    $sql = "";

    if ($isPatient) {
        $sql = "DELETE FROM patient WHERE p_id = $id";
    } else {
        $sql = "DELETE FROM doctor WHERE d_id = $id";
    }

    $stmt = mysqli_prepare($conn, $sql);
    if (mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) != 1) {
            echo "Delete query failed";
        } else {
            echo "Deleted account";
            // Delete related comments
            $sql = "DELETE FROM comment WHERE ";
            if ($isPatient) {
                $sql .= "p_id = $id";
            } else {
                $sql .= "d_id = $id";
            }
            mysqli_query($conn, $sql);

            // Delete related posts
            $sql = "DELETE FROM post WHERE ";
            if ($isPatient) {
                $sql .= "p_id = $id";
            } else {
                $sql .= "d_id = $id";
            }
            mysqli_query($conn, $sql);

            // Delete related appointments
            $sql = "DELETE FROM appointment WHERE ";
            if ($isPatient) {
                $sql .= "p_id = $id";
            } else {
                $sql .= "d_id = $id";
            }
            mysqli_query($conn, $sql);

            header("location: ../signin_page/logout.php");
            exit;
        }
    } else {
        echo "Delete query failed";
    }
}
?>
