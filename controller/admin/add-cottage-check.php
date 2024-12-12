<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (
        isset($_FILES['cottage_image']) && isset($_POST['cottage_name']) &&
        isset($_POST['cottage_price']) && isset($_POST['cottage_capacity'])
    ) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $cottage_name = validate($_POST['cottage_name']);
        $cottage_price = validate($_POST['cottage_price']);
        $cottage_capacity = validate($_POST['cottage_capacity']);
        $cottage_availability_id = 1;
        date_default_timezone_set('Asia/Manila');
        $createdDate = date("Y-m-d H:i:s");
        $img_name = $_FILES['cottage_image']['name'];
        $img_size = $_FILES['cottage_image']['size'];
        $tmp_name = $_FILES['cottage_image']['tmp_name'];
        $error = $_FILES['cottage_image']['error'];

        if ($error === 0) {
            if ($img_size > 1000000) {
                header("Location: ../../views/admin/add-cottage.php?too_large");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $img_upload_path = '../../cottages/' . $img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $stmt = $conn->prepare(" INSERT INTO tbl_cottages
                    (cottage_name, cottage_price, cottage_capacity, cottage_image, cottage_availability_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?) ");
                    $stmt->bind_param('ssssiss', $cottage_name, $cottage_price, $cottage_capacity, $img_name, $cottage_availability_id, $createdDate, $createdDate);
                    $stmt->execute();

                    header("Location: ../../views/admin/add-cottage.php?success");
                    exit();
                } else {
                    header("Location: ../../views/admin/add-cottage.php?invalid_file_type");
                    exit();
                }
            }
        } else {
            header("Location: ../../views/admin/add-cottage.php?unchange");
            exit();
        }
    } else {
        header("Location: ../../views/admin/add-cottage.php?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
