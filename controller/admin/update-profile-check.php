<?php
include "../../config.php";
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    if (isset($_POST['firstname']) && isset($_POST['middlename']) && isset($_POST['lastname'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $firstname = validate($_POST['firstname']);
        $middlename = validate($_POST['middlename']);
        $lastname = validate($_POST['lastname']);
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("F j, Y | l - h : i : s a");

        $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE firstname = ? AND middlename = ? AND lastname = ? ");
        $stmt->bind_param("sss", $firstname, $middlename, $lastname);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/profile?registered");
            exit();
        } else {

            $stmt = $conn->prepare(" UPDATE tbl_admin SET firstname = ?, middlename = ?, lastname = ?, updated_at = ? WHERE id = ? ");
            $stmt->bind_param('ssssi', $firstname, $middlename, $lastname, $updated_at, $id);
            $stmt->execute();

            header("Location: ../../views/admin/profile?updated");
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
