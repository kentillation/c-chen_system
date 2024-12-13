<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['room_category_name']) && isset($_POST['room_category_price']) &&
        isset($_POST['room_capacity']) && isset($_POST['room_details']) && isset($_POST['availability_id'])
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
        $room_details = validate($_POST['room_details']);
        $availability_id = validate($_POST['availability_id']);
        $img_url = $_FILES['img_url'];
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");
        if ($img_url['error'] === 0) {
            $allowed_exts = ['jpg', 'jpeg', 'png'];
            $file_ext = strtolower(pathinfo($img_url['name'], PATHINFO_EXTENSION));
            if (!in_array($file_ext, $allowed_exts)) {
                header("Location:../../views/admin/room-category-details.php?room_category_id=$room_category_id&wrong_file_type");
                exit();
            }
            if ($img_url['size'] > 50000000) {
                header("Location:../../views/admin/room-category-details.php?room_category_id=$room_category_id&too_large");
                exit();
            }
            $new_img_url = uniqid("IMG-", true) . ".$file_ext";
            $img_upload_path = "../../rooms/$new_img_url";
            move_uploaded_file($img_url['tmp_name'], $img_upload_path);
            $stmt = $conn->prepare(" UPDATE tbl_room_category SET img_url = ? WHERE room_category_id = ? ");
            $stmt->bind_param('si',  $new_img_url, $room_category_id);
            $stmt->execute();
        }
        // else {
        //     header("Location:../../views/admin/room-category-details.php?room_category_id=$room_category_id&upload_error");
        //     exit();
        // }
        $conn->begin_transaction();
        // try {
        $stmt = $conn->prepare(" SELECT * FROM tbl_room_category WHERE 
            room_category_name = ? AND room_category_price = ? AND room_capacity = ? AND  room_details = ? AND img_url = ? AND availability_id = ?");
        $stmt->bind_param("ssissi", $room_category_name, $room_category_price, $room_capacity, $room_details, $img_url, $availability_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/room-category-details.php?room_category_id=$room_category_id&existed");
            exit();
        } else {
            $stmt = $conn->prepare(" UPDATE tbl_room_category SET room_category_name = ?, room_category_price = ?, room_capacity = ?, room_details = ?, availability_id = ?, updated_at = ? WHERE room_category_id = ? ");
            $stmt->bind_param('ssisisi', $room_category_name, $room_category_price, $room_capacity, $room_details, $availability_id, $createdDate, $room_category_id);
            $stmt->execute();
            header("Location: ../../views/admin/room-category-details.php?room_category_id=$room_category_id&updated");
            exit();
        }
        // }
        // catch (Exception $e) {
        //     $conn->rollback();
        //     header("Location:../../views/admin/room-category-details?room_category_id=$room_category_id&error");
        //     exit();
        // }
    } else {
        header("Location: ../../views/admin/room-category-details.php?room_category_id=$room_category_id&unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
