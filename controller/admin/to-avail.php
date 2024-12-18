<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $service_id = $_GET['service_id'];
    $to_avail = 1;
    $stmt = $conn->prepare(" UPDATE tbl_services SET service_availability_id = ? WHERE service_id = ? ");
    $stmt->bind_param('ii', $to_avail,  $service_id);
    $stmt->execute();

    header("Location: ../../views/admin/services");
    exit();
} else {
    header('Location: ../../signout');
    exit();
}
