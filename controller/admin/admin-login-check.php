<?php
session_start();
include "../../config.php";
if (isset($_POST['user_name']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $user_name = validate($_POST['user_name']);
    $_password = validate($_POST['password']);
    $password = md5($_password);
    $user_data = '&user_name=' . $user_name;
    try {
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE user_name = ? AND password = ?");
        if (!$stmt) {
            throw new Exception("Database query error: " . $conn->error);
        }
        $stmt->bind_param("ss", $user_name, $password);
        if (!$stmt->execute()) {
            throw new Exception("Database query execution failed.");
        }
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['user_name'] === $user_name && $row['password'] === $password) {

                $_SESSION['id'] = $row['id'];

                header("Location: ../../views/admin/calendar");
                exit();
            } else {
                header("Location: ../../admin-login?invalid$user_data");
                exit();
            }
        } else {
            header("Location: ../../admin-login?invalid$user_data");
            exit();
        }
    } catch (Exception $e) {
        header("Location: ../../admin-login?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: ../../signout");
    exit();
}
