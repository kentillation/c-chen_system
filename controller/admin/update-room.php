<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_number']) && isset($_POST['room_category_id']) && isset($_POST['room_availability_id'])
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
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");

        $stmt = $conn->prepare(" SELECT * FROM tbl_room_number WHERE room_number = ? AND room_category_id = ? AND room_availability_id = ?");
        $stmt->bind_param("sii", $room_number, $room_category_id, $room_availability_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/room-details.php?room_number_id=$room_number_id&existed");
            exit();
        } else {

            $stmt = $conn->prepare(" UPDATE tbl_room_number SET room_number = ?, room_category_id = ?, room_availability_id = ?, created_at = ?, updated_at = ? WHERE room_number_id = ? ");
            $stmt->bind_param('siissi', $room_number, $room_category_id, $room_availability_id, $createdDate, $createdDate, $room_number_id);
            $stmt->execute();

            header("Location: ../../views/admin/room-details?room_number_id=$room_number_id&updated");
            exit();
        }
    } else {
        header("Location: ../../views/admin/room-details?room_number_id=$room_number_id&unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
