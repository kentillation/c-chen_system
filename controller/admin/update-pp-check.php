<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (isset($_FILES['img_url'])) {
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("F j, Y | l - h:i:s a");
        $img_name = $_FILES['img_url']['name'];
        $img_size = $_FILES['img_url']['size'];
        $tmp_name = $_FILES['img_url']['tmp_name'];
        $error = $_FILES['img_url']['error'];

        if ($error === 0) {
            if ($img_size > 1000000) {
                header("Location: ../../views/admin/profile?too_large");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png");
                if (in_array($img_ex_lc, $allowed_exs)) {
                    $img_upload_path = '../../views/admin/profile-pictures/' . $img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);
                    $stmt = $conn->prepare("UPDATE tbl_admin SET img_url = ?, updated_at = ? WHERE id = ?");
                    $stmt->bind_param('ssi', $img_name, $updated_at, $id);
                    $stmt->execute();
                    $target_dir = "../../views/admin/profile-pictures/";
                    $target_file = $target_dir . basename($_FILES["img_url"]["name"]);

                    header("Location: ../../views/admin/profile?updated_pp");
                    exit();
                } else {
                    header("Location: ../../views/admin/profile?invalid_file_type");
                    exit();
                }
            }
        } else {
            header("Location: ../../views/admin/profile?unchange");
            exit();
        }
    } else {
        header("Location: ../../views/admin/profile?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
