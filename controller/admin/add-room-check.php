<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_number']) && isset($_POST['room_category_id'])
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
        $img_url = $_FILES['img_url'];
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");
        try {
            $stmt = $conn->prepare(" SELECT * FROM tbl_room_number WHERE room_number = ? AND room_category_id = ?");
            $stmt->bind_param("ii", $room_number, $room_category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../../views/admin/add-room.php?existed");
                exit();
            } else {
                $availability = 1;
                $stmt = $conn->prepare(
                    " INSERT INTO tbl_room_number (room_number, room_category_id, room_availability_id, updated_at) VALUES (?, ?, ?, ?) "
                );
                $stmt->bind_param('siis', $room_number, $room_category_id, $availability, $createdDate);
                $stmt->execute();
                header("Location: ../../views/admin/add-room.php?success");
                exit();
            }
        } catch (Exception $e) {
            $conn->rollback();
            header("Location:../../views/admin/add-room?booking_error");
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
