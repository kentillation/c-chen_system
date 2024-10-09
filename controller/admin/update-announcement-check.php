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
    if (isset($_POST['announcement'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id = validate($_GET['id']);
        $announcement = validate($_POST['announcement']);
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("Y-m-d h:i:sa");

        $stmt = $conn->prepare("UPDATE tbl_announcements SET announcement = ?, updated_at = ? WHERE id = ? ");
        $stmt->bind_param('ssi', $announcement, $updated_at, $id);
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
                $subject = "C-chen Paradise Beach Resort | Announcement [Edited]";
                $message = "Announcement!!! \n \n";
                $message = "[Edited] \n";
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

        header("Location: ../../views/admin/announcements?updated");
        exit();
    } else {
        header("Location: ../../views/admin/announcements?error");
        exit();
    }
} else {
    header('Location: ../../');
    exit;
}