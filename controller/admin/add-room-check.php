<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_number']) && isset($_POST['room_category_id']) &&
        isset($_POST['room_capacity'])
    ) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $room_number_id = validate($_GET['room_number_id']);
        $room_number = validate($_POST['room_number']);
        $room_category_id = validate($_POST['room_category_id']);
        $room_capacity = validate($_POST['room_capacity']);
        $room_availability_id = 1;
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");

        $stmt = $conn->prepare(" SELECT * FROM tbl_room_number WHERE room_number = ? AND room_category_id = ? AND room_availability_id = ?");
        $stmt->bind_param("sii", $room_number, $room_category_id, $room_availability_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/add-room.php?existed");
            exit();
        } else {

            $stmt = $conn->prepare(" INSERT INTO tbl_room_number
            (room_number, room_category_id, room_capacity, room_availability_id, updated_at) VALUES (?, ?, ?, ?, ?) ");
            $stmt->bind_param('iiiis', $room_number, $room_category_id, $room_capacity, $room_availability_id, $createdDate);
            $stmt->execute();

            header("Location: ../../views/admin/add-room.php?success");
            exit();
        }
    } else {
        header("Location: ../../views/admin/add-room.php?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
