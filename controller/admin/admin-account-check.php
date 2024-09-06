<?php
include "../../config.php";
session_start();

// Send email using PHPMailer library
require '../../email-plugin/PHPMailer.php';
require '../../email-plugin/SMTP.php';
require '../../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['id'])) {
    if (isset($_POST['email']) && isset($_POST['user_name']) && isset($_POST['password'])) {

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $email = validate($_POST['email']);
        $user_name = validate($_POST['user_name']);
        $_password = validate($_POST['password']);
        $password = validate($_POST['password']);
        $firstname = "first_name";
        $middlename = "middle_name";
        $lastname = "last_name";
        date_default_timezone_set('Asia/Manila');
        $created_at = date("F j, Y | l - h : i : s a");
        $updated_at = date("F j, Y | l - h : i : s a");

        $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE user_name = ? OR email = ? ");
        $stmt->bind_param("ss", $user_name, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../../views/admin/admin-accounts?registered");
            exit();
        } else {

            $password = md5($password);
            $stmt = $conn->prepare("INSERT INTO tbl_admin (email, user_name, password, firstname, middlename, lastname, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
            $stmt->bind_param('ssssssss', $email, $user_name, $password, $firstname, $middlename, $lastname, $created_at, $updated_at);
            $stmt->execute();
            $result = $stmt->get_result();

            $mail = new PHPMailer(true);
            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'christianschool.main@gmail.com';
                $mail->Password = 'lhkvevgaglyugygu';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Email content
                date_default_timezone_set('Asia/Manila');
                $datetime = date("F j, Y - l") . " | " . date("h:i:sa");
                $subject = 'Kent App | Admin Account Creation';
                $message = "Your account has been added to the system on $datetime. \n \n";
                $message .= "Below are your admin credentials. \n \n";
                $message .= "Email: " . $email . "\n";
                $message .= "Username: " . $user_name . "\n";
                $message .= "Password: " . $_password . "\n \n";
                $message .= "Make sure to save your credentials to avoid inconvenience. \n \n \n";
                $message .= "Note: This is a system-generated email. Please do not reply!.";
                $mail->setFrom('christianschool.main@gmail.com', 'Kent App');
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->send();
            }
            catch (Exception $e) {
                echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
            }

            header("Location: ../../views/admin/admin-accounts?success");
            exit();
            
        }
    } else {
        header("Location: ../../views/admin/admin-accounts?error");
        exit();
    }
} else {
    header('Location: ../../');
    exit;
}