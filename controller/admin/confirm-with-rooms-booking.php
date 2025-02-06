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

        $stmtBookings1 = $conn->prepare(" SELECT * FROM tbl_bookings 
                WHERE booking_id = ? ");
        $stmtBookings1->bind_param('i', $booking_id);
        $stmtBookings1->execute();
        $resultBookings1 = $stmtBookings1->get_result();
        $rowBookings1 = $resultBookings1->fetch_assoc();
        $fullname = $rowBookings1['fullname'];
        $email = $rowBookings1['email'];
        $reference_number = $rowBookings1['reference_number'];
        $created_at = (new DateTime($rowBookings1['created_at']))->format("F j, Y");
        $date_check_in = (new DateTime($rowBookings1['date_check_in']))->format("F j, Y");
        $date_check_out = (new DateTime($rowBookings1['date_check_out']))->format("F j, Y");
        $d_check_in = new DateTime($rowBookings1['date_check_in']);
        $d_check_out = new DateTime($rowBookings1['date_check_out']);
        $interval = $d_check_in->diff($d_check_out);
        $days = $interval->days;
        $total_payment = 0;
        $remaining_balance = 0;
        $stmt = $conn->prepare(" SELECT 
        t_b.*,
        (SELECT SUM(t_rc.room_category_price) FROM tbl_booking_room t_br 
        INNER JOIN tbl_room_category t_rc ON t_br.room_category_id = t_rc.room_category_id
        WHERE t_br.booking_id = t_b.booking_id) AS room_payment,
    
        (SELECT SUM(t_c.cottage_price) FROM tbl_booking_cottage t_bc
        INNER JOIN tbl_cottages t_c ON t_bc.cottage_id = t_c.cottage_id
        WHERE t_bc.booking_id = t_b.booking_id) AS cottage_payment,
    
        (SELECT SUM(t_s.service_price) FROM tbl_booking_service t_bs
        INNER JOIN tbl_services t_s ON t_bs.service_id = t_s.service_id
        WHERE t_bs.booking_id = t_b.booking_id) AS service_payment
        FROM tbl_bookings t_b
        WHERE t_b.booking_id = ?
                GROUP BY t_b.reference_number ");
        $stmt->bind_param('i', $booking_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $room_payment = $row['room_payment'];
        $cottage_payment = $row['cottage_payment'];
        $service_payment = $row['service_payment'];
        $room = ($room_payment ?? 0) * $days;
        // $cottage = ($cottage_payment ?? 0) * $days;
        $service = ($service_payment ?? 0) * $days;

        $total_payment = $room + $cottage_payment + $service;
        $total_payment = number_format($total_payment);

        $down_payment = number_format($_POST['down_payment']);

        $remaining_balance = $total_payment - $down_payment;
        $remaining_balance = number_format($remaining_balance);

        // echo "Total payment: $total_payment \n";
        // echo "Down payment: $down_payment \n";
        // echo "Remaining balance: $remaining_balance \n";

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
            $message .= "Good day $fullname! \n";
            $message .= "Your booking has been confirmed successfully! \n \n";
            $message .= "Total payment: ₱$total_payment \n";
            $message .= "Down payment: ₱$down_payment \n";
            $message .= "Remaining balance: ₱$remaining_balance \n";
            $message .= "Reference #: $reference_number \n \n";
            $message .= "Kindly, prepare exact amount upon check in. Thank you and see you! \n \n";
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
