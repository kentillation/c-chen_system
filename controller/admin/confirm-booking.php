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
    $booking_id = $_GET['booking_id'];
    $confirm = 2;

    $stmt = $conn->prepare(" SELECT 
    tbl_bookings.id,
    tbl_bookings.reference_number,
    tbl_bookings.fullname,
    tbl_bookings.email,
    tbl_bookings.phone_number,
    tbl_bookings.date_check_in,
    tbl_bookings.date_check_out,
    tbl_services.service_name,
    tbl_mode_of_payment.mode_of_payment
    FROM tbl_bookings 
    INNER JOIN tbl_services ON tbl_bookings.service_id = tbl_services.service_id
    INNER JOIN tbl_mode_of_payment ON tbl_bookings.tbl_mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
    WHERE tbl_bookings.id = ? ");
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $reference_number = $row['reference_number'];
    $fullname = $row['fullname'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $date_check_in = $row['date_check_in'];
    $date_check_out = $row['date_check_out'];
    $service_name = $row['service_name'];
    $mode_of_payment = $row['mode_of_payment'];

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
        $message = "Cordial greeting! \n";
        $message .= "Good day $fullname! Your booking has been confirmed successfully! \n";
        $message .= "Refence #: $reference_number \n";
        $message .= "Name: $fullname \n";
        $message .= "Phone #: $phone_number \n";
        $message .= "Date started: $date_check_in \n";
        $message .= "Date ended: $date_check_out \n";
        $message .= "Services: $service_name \n";
        $message .= "Modeof payment: $mode_of_payment \n\n";
        $message .= "Note: This is a system-generated email. Please do not reply!";
        $mail->setFrom('christianschool.main@gmail.com', 'C-chen Beach Resort');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();

        header("Location: ../../views/admin/bookings?updated");
        exit();
    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
    }
} else {
    header('Location: ../../signout');
    exit();
}
