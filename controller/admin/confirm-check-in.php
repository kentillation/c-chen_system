<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $booking_id = validate($_GET['booking_id']);
    date_default_timezone_set('Asia/Manila');
    $dateCreated = date("Y-m-d H:i:s");
    $checking_status_id = 1;

    $stmt = $conn->prepare("UPDATE tbl_bookings SET checking_status_id = ? WHERE booking_id = ? ");
    $stmt->bind_param('ii', $checking_status_id, $booking_id);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO tbl_checking_guest (booking_id, checking_status_id, created_at) VALUES (?, ?, ?) ");
    $stmt->bind_param('iis', $booking_id, $checking_status_id, $dateCreated);
    $stmt->execute();

    header("Location: ../../views/admin/checked-in-guests");
    exit();
} else {
    header('Location: ../../');
    exit;
}
