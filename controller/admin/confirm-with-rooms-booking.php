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
    $confirm = 2;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn->begin_transaction();
        function validate($data)
        {
            return htmlspecialchars(stripslashes(trim($data)));
        }
        $room_numbers = $_POST['room_number'];
        $down_payment = $_POST['down_payment'];
        foreach ($room_numbers as $room_category_id => $room_numbers_list) {
            $room_category_id = validate($room_category_id);
            $stmt = $conn->prepare("SELECT booking_room_id FROM tbl_booking_room WHERE booking_id = ? AND room_category_id = ? ORDER BY booking_room_id ASC");
            $stmt->bind_param('ii', $booking_id, $room_category_id);
            $stmt->execute();
            $result = $stmt->get_result();
            foreach ($room_numbers_list as $room_number) {
                $booking_room_id = $result->fetch_assoc()['booking_room_id'];
                $room_number = validate($room_number);

                $update_stmt = $conn->prepare("UPDATE tbl_booking_room SET room_number = ? WHERE booking_room_id = ?");
                $update_stmt->bind_param('si', $room_number, $booking_room_id);
                if (!$update_stmt->execute()) {
                    throw new Exception("Failed to update booking_room_id: $booking_room_id");
                }
            }
        }
        $conn->commit();

        $stmt = $conn->prepare(" UPDATE tbl_bookings SET down_payment = ?, booking_status_id = ? WHERE booking_id = ? ");
        $stmt->bind_param('iis', $down_payment, $confirm, $booking_id);
        $stmt->execute();

        $stmt = $conn->prepare(" SELECT * FROM tbl_bookings WHERE booking_id = ? ");
        $stmt->bind_param('i', $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $reference_number = $row['reference_number'];
        $fullname = $row['fullname'];

        $remaining_balance = $total_payment - $down_payment;

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

            $message .= "Good day $fullname! Your booking has been confirmed successfully! \n";
            $message .= "Total payment: $total_payment \n";
            $message .= "Down payment: $down_payment \n";
            $message .= "Remaining balance: $remaining_balance \n";
            $message .= "Reference #: $reference_number \n \n";
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
