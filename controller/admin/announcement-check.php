<?php
include "../../config.php";
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Send email using PHPMailer library
require '../../email-plugin/PHPMailer.php';
require '../../email-plugin/SMTP.php';
require '../../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['id'])) {
    if (isset($_POST['announcement'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $admin_id = $_SESSION['id'];
        $announcement = validate($_POST['announcement']);
        date_default_timezone_set('Asia/Manila');
        $created_at = date("Y-m-d h:i:sa");
        $updated_at = date("Y-m-d h:i:sa");

        $stmt = $conn->prepare("INSERT INTO tbl_announcements (admin_id, announcement, created_at, updated_at) 
            VALUES (?, ?, ?, ?) ");
        $stmt->bind_param('isss', $admin_id, $announcement, $created_at, $updated_at);
        $stmt->execute();

        $stmt = $conn->prepare(" SELECT * FROM tbl_bookings ");
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc()) {
            $email = $row['email'];
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
                $subject = "C-chen Paradise Beach Resort | Announcement";
                $message = "Announcement!!! \n \n";
                $message .= "$announcement \n \n \n";
                $message .= "Note: This is a system-generated email. Please do not reply!.";
                $mail->setFrom('christianschool.main@gmail.com', "C-chen Paradise Beach Resort");
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->send();
            } catch (Exception $e) {
                echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
            }
        }

        header("Location: ../../views/admin/announcements?success");
        exit();
    } else {
        header("Location: ../../views/admin/announcements?error");
        exit();
    }
} else {
    header('Location: ../../');
    exit;
}
