<?php
session_start();
if (!isset ($_SESSION['logged_in']) || $_SESSION["logged_in"] != true) {
    header("Location:admin_login.php");
    exit();
}
include ("db_connection.php");

if (isset ($_GET["id"])) {
    $appointment_id = $_GET['id'];
    $status = 'Success';
    $approve = "UPDATE `appointments` SET `donated`='$status' WHERE `appointment_id` = '$appointment_id'";
    $statement = $conn->prepare($approve);
    $statement->execute();
    header("Location:admin_manage_appointments.php");
}
