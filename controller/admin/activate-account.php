<?php
include '../../config.php';
session_start();
// Send email using PHPMailer library
require '../../email-plugin/PHPMailer.php';
require '../../email-plugin/SMTP.php';
require '../../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    if ($_SESSION['id'] !== 1) {
        header("Location: ../../signout");
        exit;
    } else {
        $student_id = $_GET['student_id'];
        $account_status = 2;
        try {
            $stmt = $conn->prepare('UPDATE tbl_student SET account_status = ? WHERE student_id = ?');
            $stmt->bind_param('ii', $account_status, $student_id);
            $stmt->execute();

            $stmt = $conn->prepare('SELECT * FROM tbl_student WHERE student_id = ?');
            $stmt->bind_param('i', $student_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $email = $row['email'];

            if ($stmt->execute()) {

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
                    $subject = 'Kent App | Account Activation';
                    $message = "Your account has been activated successfully on $datetime.\n";
                    $message .= "Login to your Kent Application to get started. \n\n";
                    $message .= "Note: This is a system-generated email. Please do not reply!.";
                    $mail->setFrom('christianschool.main@gmail.com', 'Kent App');
                    $mail->addAddress($email);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->send();

                    $stmt = $conn->prepare('DELETE FROM tbl_activation WHERE student_id = ?');
                    $stmt->bind_param('i', $student_id);
                    $stmt->execute();

                    header("Location: ../../views/admin/pending-accounts?success");
                    exit();
                
                } catch (Exception $e) {
                    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
                }
                
            } else {
                header("Location: ../../views/admin/pending-accounts?unknown");
                exit();
            }
        } catch (Exception $e) {
            header("Location: ../../admin-login?error=" . urlencode($e->getMessage()));
            exit();
        }
    }
} else {
    header('Location: ../../');
    exit;
}
