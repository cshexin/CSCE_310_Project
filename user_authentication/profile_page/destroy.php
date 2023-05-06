<?PHP 

include('../../config/db_connect.php');

if(!isset($_SESSION)) { session_start(); }

$id = 0;
$sql = "";

if (!isset($_SESSION["id"])) {
    header("location: ../signin_page");
} else {
    if($_SESSION['isPatient']){
        $sql = "DELETE FROM patient WHERE p_id = {$_SESSION['id']}";
    } else {
        $sql = "DELETE FROM doctor WHERE d_id = {$_SESSION['id']}";
    }
    $stmt = mysqli_prepare($conn, $sql);
    if (mysqli_stmt_execute($stmt)) {
        if(mysqli_stmt_affected_rows($stmt) != 1){
            echo "Delete query failed";
        } else{
            echo "Deleted account";
            header("location: ../signin_page/logout.php");
            exit;
        }
    } else{
        echo "Delete query failed";
    }

}   
?>