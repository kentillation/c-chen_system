<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_number']) && isset($_POST['room_category_id']) && isset($_POST['room_category_price']) &&
        isset($_POST['room_capacity']) && isset($_POST['room_availability_id'])
    ) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $room_number = validate($_POST['room_number']);
        $room_category_id = validate($_POST['room_category_id']);
        $room_category_price = validate($_POST['room_category_price']);
        $room_capacity = validate($_POST['room_capacity']);
        $room_availability_id = validate($_POST['room_availability_id']);
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");

        $stmt = $conn->prepare(" SELECT * FROM tbl_room_number WHERE room_number = ? AND room_category_id = ? ");
        $stmt->bind_param("ii", $room_number, $room_category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/rooms.php?existed");
            exit();
        } else {

            $stmt = $conn->prepare(" INSERT INTO tbl_room_number (room_number, room_category_id, room_capacity, room_availability_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param('siiiss', $room_number, $room_category_id, $room_capacity, $room_availability_id, $createdDate, $createdDate);
            $stmt->execute();

            header("Location: ../../views/admin/rooms?success");
            exit();
        }
    } else {
        header("Location: ../../views/admin/rooms?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
