<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_POST['cottage_id']) && isset($_POST['cottage_name']) && isset($_POST['cottage_price']) && isset($_POST['cottage_capacity']) && isset($_POST['cottage_availability_id'])
    ) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $cottage_id = $_POST['cottage_id'];
        $cottage_name = validate($_POST['cottage_name']);
        $cottage_price = validate($_POST['cottage_price']);
        $cottage_capacity = validate($_POST['cottage_capacity']);
        $cottage_availability_id = validate($_POST['cottage_availability_id']);
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");

        $stmt = $conn->prepare(" SELECT * FROM tbl_cottages WHERE cottage_name = ? AND cottage_price = ? AND cottage_capacity = ? AND cottage_availability_id = ?");
        $stmt->bind_param("sssi", $cottage_name, $cottage_price, $cottage_capacity, $cottage_availability_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/cottage-details.php?cottage_id=$cottage_id&existed");
            exit();
        } else {
            $stmt = $conn->prepare(" UPDATE tbl_cottages SET cottage_name = ?, cottage_price = ?, cottage_capacity = ?, cottage_availability_id = ?, updated_at = ? WHERE cottage_id = ? ");
            $stmt->bind_param('sssisi', $cottage_name, $cottage_price, $cottage_capacity, $cottage_availability_id, $createdDate, $cottage_id);
            $stmt->execute();

            header("Location: ../../views/admin/cottage-details?cottage_id=$cottage_id&updated");
            exit();
        }
    } else {
        header("Location: ../../views/admin/cottage-details?cottage_id=$cottage_id&unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
