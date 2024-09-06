<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (isset($_POST['user_name'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $user_name = validate($_POST['user_name']);
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("F j, Y | l - h:i:sa");

        $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE user_name = ? AND id = ? ");
        $stmt->bind_param("si", $user_name, $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/profile?registered_user_name");
            exit();
        } else {

            $stmt = $conn->prepare(" UPDATE tbl_admin SET user_name = ?, updated_at = ? WHERE id = ? ");
            $stmt->bind_param('ssi', $user_name, $updated_at, $id);
            $stmt->execute();

            header("Location: ../../admin-login?user_name_changed");
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
