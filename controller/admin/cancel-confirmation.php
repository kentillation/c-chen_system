<?php
session_start();
include "../../config.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../../email-plugin/PHPMailer.php';
require '../../email-plugin/SMTP.php';
require '../../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['id'])) {
    $booking_id = $_GET['booking_id'];
    $cancelled = 4;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        function validate($data)
        {
            return htmlspecialchars(stripslashes(trim($data)));
        }
        $reason_for_cancellation = $_POST['reason_for_cancellation'];

        $stmt = $conn->prepare(" UPDATE tbl_bookings SET booking_status_id = ?, reason_for_cancellation = ? WHERE booking_id = ? ");
        $stmt->bind_param('iss', $cancelled, $reason_for_cancellation, $booking_id);
        $stmt->execute();

        $stmt = $conn->prepare(" SELECT * FROM tbl_bookings WHERE booking_id = ? ");
        $stmt->bind_param('i', $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
        $reference_number = $row['reference_number'];

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
            $subject = 'C-chen Beach Resort | Cancelled Booking';
            $message = "Cordial greetings! \n \n";
            $message .= "Good day $fullname! I hope this email finds you well. \n";
            $message .= "We cancelled your booking due to reason: . \n";
            $message .= "$reason_for_cancellation \n";
            $message .= "We are asking your kind consideration regarding with this reason. Thank you! \n";
            $message .= "Transaction Reference #: $reference_number \n \n";
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
    }
} else {
    header('Location: ../../signout');
    exit();
}
