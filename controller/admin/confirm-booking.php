<?php
session_start();
include "../../config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Send email using PHPMailer library
require '../../email-plugin/PHPMailer.php';
require '../../email-plugin/SMTP.php';
require '../../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['id'])) {
    $booking_id = $_GET['booking_id'];
    $confirm = 2;

    $stmt = $conn->prepare(" SELECT * FROM tbl_bookings WHERE booking_id = ? ");
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
    $email = $row['email'];
    $reference_number = $row['reference_number'];

    $stmt = $conn->prepare(" UPDATE tbl_bookings SET booking_status_id = ? WHERE reference_number = ? ");
    $stmt->bind_param('is', $confirm, $reference_number);
    $stmt->execute();

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
        $subject = 'C-chen Beach Resort | Confirmed Booking';
        $message = "Cordial greetings! \n \n";
        $message .= "Good day $fullname! Your booking has been confirmed successfully with reference #: $reference_number. \n";
        $message .= "Kindly, prepare exact amount when payment arise over the counter. Thank you and see you! \n \n";
        $message .= "Note: This is a system-generated email. Please do not reply!";
        $mail->setFrom('christianschool.main@gmail.com', 'C-chen Beach Resort');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
    }
    header("Location: ../../views/admin/bookings?updated");
    exit();
} else {
    header('Location: ../../signout');
    exit();
}
