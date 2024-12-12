<?php
include './config.php';

if (isset($_POST['date_check_in'])) {
    $date_check_in = $_POST['date_check_in'];
    $cottage_id = $_POST['cottage_id'];
    $stmt = $conn->prepare(" SELECT COUNT(*) as booked_cottage FROM tbl_booking_cottage bc INNER JOIN tbl_bookings b ON bc.booking_id = b.booking_id
        WHERE bc.cottage_id = ? AND ? BETWEEN b.date_check_in AND b.date_check_out ");
    $stmt->bind_param('is', $cottage_id, $date_check_in);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $availableCottage = $row['booked_cottage'] ?? 0 . " available cottage(s)";
    echo json_encode(['available_cottages' => $availableCottage]);
}
