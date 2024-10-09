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
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id = validate($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM tbl_announcements WHERE id = ? ");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $announcement = $row['announcement'];

    $stmt = $conn->prepare(" SELECT * FROM tbl_bookings ");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
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
            $subject = "C-chen Paradise Beach Resort | Announcement [Removed]";
            $message = "The announcement below is already removed. \n \n";
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

    $stmt = $conn->prepare("DELETE FROM tbl_announcements WHERE id = ? ");
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header("Location: ../../views/admin/announcements?remove");
    exit();
} else {
    header('Location: ../../');
    exit;
}
