<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_category_name']) && isset($_POST['room_category_price']) &&
        isset($_POST['room_capacity']) && isset($_POST['room_details']) && isset($_FILES['img_url'])
    ) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $room_category_id = validate($_GET['room_category_id']);
        $room_category_name = validate($_POST['room_category_name']);
        $room_category_price = validate($_POST['room_category_price']);
        $room_capacity = validate($_POST['room_capacity']);
        $availability_id = 1;
        $img_url = $_FILES['img_url'];
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");
        if ($img_url['error'] === 0) {
            $allowed_exts = ['jpg', 'jpeg', 'png'];
            $file_ext = strtolower(pathinfo($img_url['name'], PATHINFO_EXTENSION));
            if (!in_array($file_ext, $allowed_exts)) {
                header("Location:../../views/admin/add-room-category.php?wrong_file_type");
                exit();
            }
            if ($img_url['size'] > 50000000) {
                header("Location:../../views/admin/add-room-category.php?too_large");
                exit();
            }
            $new_img_url = uniqid("IMG-", true) . ".$file_ext";
            $img_upload_path = "../../rooms/$new_img_url";
            move_uploaded_file($img_url['tmp_name'], $img_upload_path);
        } else {
            header("Location:../../views/admin/add-room-category.php?upload_error");
            exit();
        }
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare(" SELECT * FROM tbl_room_category WHERE room_category_name = ? AND availability_id = ?");
            $stmt->bind_param("si", $room_category_name, $availability_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../../views/admin/add-room-category.php?existed");
                exit();
            } else {
                $stmt = $conn->prepare(" INSERT INTO tbl_room_category (room_category_name, room_category_price, room_capacity, room_details, img_url, availability_id, updated_at, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
                $stmt->bind_param('ssississ', $room_category_name, $room_category_price, $room_capacity, $room_details, $new_img_url, $availability_id, $createdDate, $createdDate);
                $stmt->execute();
                header("Location: ../../views/admin/add-room-category.php?success");
                exit();
            }
        } catch (Exception $e) {
            $conn->rollback();
            header("Location:../../views/admin/add-room-category?error");
            exit();
        }
    } else {
        header("Location: ../../views/admin/add-room-category.php?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
