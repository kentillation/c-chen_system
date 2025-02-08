<?php
include "../../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $reservation_id = validate($_GET['reservation_id']);
    date_default_timezone_set('Asia/Manila');
    $dateCreated = date("Y-m-d H:i:s");
    $checking_status_id = 2;

    $stmt = $conn->prepare("UPDATE tbl_reservation SET checking_status_id = ?, updated_at = ? WHERE reservation_id = ? ");
    $stmt->bind_param('isi', $checking_status_id, $dateCreated, $reservation_id);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO tbl_checking_guest (reservation_id, checking_status_id, created_at, updated_at) VALUES (?, ?, ?, ?) ");
    $stmt->bind_param('iiss', $reservation_id, $checking_status_id, $dateCreated, $dateCreated);
    $stmt->execute();

    header("Location: ../../views/admin/checked-out-guests");
    exit();
} else {
    header('Location: ../../');
    exit;
}
