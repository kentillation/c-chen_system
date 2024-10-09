<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $booking_id = $_GET['booking_id'];
    $confirm = 2;
    $stmt = $conn->prepare(" UPDATE tbl_bookings SET booking_status_id = ? WHERE id = ? ");
    $stmt->bind_param('ii', $confirm, $booking_id);
    $stmt->execute();

    header("Location: ../../views/admin/bookings?updated");
    exit();
} else {
    header('Location: ../../signout');
    exit();
}
