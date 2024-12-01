<?php
include './config.php';

if (isset($_POST['date_check_in'])) {
    $date_check_in = $_POST['date_check_in'];
    $room_category_id = $_POST['room_category_id'];
    $stmt = $conn->prepare(" SELECT COUNT(*) as booked_rooms FROM tbl_booking_room br INNER JOIN tbl_bookings b ON br.booking_id = b.booking_id
        WHERE br.room_category_id = ? AND ? BETWEEN b.date_check_in AND b.date_check_out ");
    $stmt->bind_param('is', $room_category_id, $date_check_in);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $bookedRooms = $row['booked_rooms'] ?? 0;
    $totalRoomsStmt = $conn->prepare(" SELECT COUNT(*) as total_rooms FROM tbl_room_number WHERE room_category_id = ? ");
    $totalRoomsStmt->bind_param('i', $room_category_id);
    $totalRoomsStmt->execute();
    $totalRoomsResult = $totalRoomsStmt->get_result();
    $totalRoomsRow = $totalRoomsResult->fetch_assoc();
    $totalRooms = $totalRoomsRow['total_rooms'] ?? 0;
    $availableRooms = $totalRooms - $bookedRooms . " available room(s)";
    echo json_encode(['available_rooms' => $availableRooms]);
}
