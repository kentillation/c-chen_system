<?php
include './config.php';

if (isset($_POST['date_check_in'])) {
    $date_check_in = $_POST['date_check_in'];
    $service_id = $_POST['service_id'];
    $stmt = $conn->prepare(" SELECT COUNT(*) as booked_service FROM tbl_booking_service bs INNER JOIN tbl_bookings b ON bs.booking_id = b.booking_id
        WHERE bs.service_id = ? AND ? BETWEEN b.date_check_in AND b.date_check_out ");
    $stmt->bind_param('is', $service_id, $date_check_in);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $availService = $row['booked_service'] ?? 0;
    $totalServiceStmt = $conn->prepare(" SELECT COUNT(*) as total_service FROM tbl_services WHERE service_id = ? ");
    $totalServiceStmt->bind_param('i', $service_id);
    $totalServiceStmt->execute();
    $totalServiceResult = $totalServiceStmt->get_result();
    $totalServiceRow = $totalServiceResult->fetch_assoc();
    $totalService = $totalServiceRow['total_service'] ?? 0;
    $availableService = $totalService - $availService;
    echo json_encode(['available_service' => $availableService]);
}
