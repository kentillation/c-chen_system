<?php
include '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Send email using PHPMailer library
require '../email-plugin/PHPMailer.php';
require '../email-plugin/SMTP.php';
require '../email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function validate($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $fullname = validate($_POST['fullname']);
    $email = validate($_POST['email']);
    $phone_number = validate($_POST['phone_number']);
    $date_check_in = validate($_POST['date_check_in']);
    $date_check_out = validate($_POST['date_check_out']);
    $message = validate($_POST['message']);
    $mode_of_payment_id = validate($_POST['mode_of_payment_id']);
    $pax = validate($_POST['pax']);
    $evidence = $_FILES['evidence'];
    date_default_timezone_set('Asia/Manila');
    $created_at = date("Y-m-d h:i:s");

    function generateReferenceNumber($length = 10)
    {
        $referenceNumber = '';
        for ($i = 0; $i < $length; $i++) {
            $referenceNumber .= mt_rand(0, 9);
        }
        return $referenceNumber;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location:../booking.php?invalid_email");
        exit();
    }

    if ($evidence['error'] === 0) {
        $allowed_exts = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($evidence['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed_exts)) {
            header("Location:../booking.php?wrong_file_type");
            exit();
        }

        if ($evidence['size'] > 50000000) {
            header("Location:../booking.php?too_large");
            exit();
        }

        $new_evidence = uniqid("IMG-", true) . ".$file_ext";
        $img_upload_path = "../evidence/$new_evidence";
        move_uploaded_file($evidence['tmp_name'], $img_upload_path);
    } else {
        header("Location:../booking.php?upload_error");
        exit();
    }

    $cottage_ids = isset($_POST['cottage_id']) ? (array)$_POST['cottage_id'] : [];
    $room_category_ids = isset($_POST['room_category_id']) ? (array)$_POST['room_category_id'] : [];
    $service_ids = isset($_POST['service_id']) ? (array)$_POST['service_id'] : [];
    $referenceNumber = generateReferenceNumber();

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare('INSERT INTO tbl_bookings (reference_number, fullname, email, phone_number, date_check_in, date_check_out, message, mode_of_payment_id, evidence, booking_status_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $booking_status_id = 1;
        $stmt->bind_param('sssssssisis', $referenceNumber, $fullname, $email, $phone_number, $date_check_in, $date_check_out, $message, $mode_of_payment_id, $new_evidence, $booking_status_id, $created_at);
        $stmt->execute();
        $booking_id = $stmt->insert_id;

        $stmt = $conn->prepare('INSERT INTO tbl_schedule (booking_id, fullname, start_datetime, end_datetime, created_at) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('issss', $booking_id, $fullname, $date_check_in, $date_check_out, $created_at);
        $stmt->execute();

        foreach ($cottage_ids as $cottage_id) {
            $cottage_id = validate($cottage_id);
            $stmtCottage = $conn->prepare('INSERT INTO tbl_booking_cottage (booking_id, cottage_id, reference_number, created_at) VALUES (?, ?, ?, ?)');
            $stmtCottage->bind_param('iiss', $booking_id, $cottage_id, $referenceNumber, $created_at);
            $stmtCottage->execute();
        }

        foreach ($room_category_ids as $room_category_id) {
            $room_category_id = validate($room_category_id);
            $stmtRooms = $conn->prepare('INSERT INTO tbl_booking_room (booking_id, pax, room_category_id, reference_number, created_at) VALUES (?, ?, ?, ?, ?)');
            $stmtRooms->bind_param('iiiss', $booking_id, $pax, $room_category_id, $referenceNumber, $created_at);
            if (!$stmtRooms->execute()) {
                $success = false;
                break;
            }
        }

        foreach ($service_ids as $service_id) {
            $service_id = validate($service_id);
            $stmtOthers = $conn->prepare('INSERT INTO tbl_booking_service (booking_id, service_id, reference_number, created_at) VALUES (?, ?, ?, ?)');
            $stmtOthers->bind_param('iiss', $booking_id, $service_id, $referenceNumber, $created_at);
            if (!$stmtOthers->execute()) {
                $success = false;
                break;
            }
        }

        $stmtBookingCottage = $conn->prepare(" SELECT 
        tbl_booking_cottage.cottage_id,
        tbl_booking_cottage.reference_number,
        tbl_cottages.cottage_name
        FROM tbl_booking_cottage
        INNER JOIN tbl_cottages ON tbl_booking_cottage.cottage_id = tbl_cottages.cottage_id
        WHERE tbl_booking_cottage.reference_number = ? ");
        $stmtBookingCottage->bind_param('s', $referenceNumber);
        $stmtBookingCottage->execute();
        $resultBookingCottage = $stmtBookingCottage->get_result();
        $cottage_names = [];
        while ($rowsBookingCottage = $resultBookingCottage->fetch_assoc()) {
            $cottage_names[] = $rowsBookingCottage['cottage_name'];
        }
        $cottage_name = implode(", ", $cottage_names);

        $stmtBookingroom = $conn->prepare(" SELECT 
        tbl_booking_room.room_category_id,
        tbl_booking_room.reference_number,
        tbl_room_category.room_category_name
        FROM tbl_booking_room
        INNER JOIN tbl_room_category ON tbl_booking_room.room_category_id = tbl_room_category.room_category_id
        WHERE tbl_booking_room.reference_number = ? ");
        $stmtBookingroom->bind_param('s', $referenceNumber);
        $stmtBookingroom->execute();
        $resultRoomBooking = $stmtBookingroom->get_result();
        $room_category_names = [];
        while ($rowsRoomBooking = $resultRoomBooking->fetch_assoc()) {
            $room_category_names[] = $rowsRoomBooking['room_category_name'];
        }
        $room_category_name = implode(", ", $room_category_names);

        $stmtBookingroom = $conn->prepare(" SELECT 
        tbl_booking_service.service_id,
        tbl_booking_service.reference_number,
        tbl_services.service_name
        FROM tbl_booking_service
        INNER JOIN tbl_services ON tbl_booking_service.service_id = tbl_services.service_id
        WHERE tbl_booking_service.reference_number = ? ");
        $stmtBookingroom->bind_param('s', $referenceNumber);
        $stmtBookingroom->execute();
        $resultRoomBooking = $stmtBookingroom->get_result();
        $service_names = [];
        while ($rowsRoomBooking = $resultRoomBooking->fetch_assoc()) {
            $service_names[] = $rowsRoomBooking['service_name'];
        }
        $service_name = implode(", ", $service_names);

        $stmt = $conn->prepare(
            " SELECT 
        tbl_bookings.booking_id,
        tbl_bookings.reference_number,
        tbl_bookings.fullname,
        tbl_bookings.email,
        tbl_bookings.phone_number,
        tbl_bookings.date_check_in,
        tbl_bookings.date_check_out,
        tbl_mode_of_payment.mode_of_payment
        FROM tbl_bookings 
        INNER JOIN tbl_mode_of_payment ON tbl_bookings.mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
        WHERE tbl_bookings.booking_id = ? "
        );
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
        $mode_of_payment = $row['mode_of_payment'];

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
            $subject = 'C-chen Beach Resort | Booking';
            $message = "Cordial greetings! \n\n";
            $message .= "Good day $fullname! Your booking has been submitted successfully! \n";
            $message .= "The following are your details: \n \n";
            $message .= "Name: $fullname \n";
            $message .= "Phone #: $phone_number \n";
            $message .= "Date check-in: $date_check_in \n";
            $message .= "Date check-out: $date_check_out \n";
            $message .= "Cottage(s): $cottage_name \n";
            $message .= "Room type(s): $room_category_name \n";
            $message .= "Service(s): $service_name \n";
            $message .= "Mode of payment: $mode_of_payment \n\n";
            $message .= "Refence #: $reference_number \n";
            $message .= "Note: This is a system-generated email. Please do not reply!";
            $mail->setFrom('christianschool.main@gmail.com', 'C-chen Beach Resort');
            $mail->addAddress($email);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        }

        $conn->commit();
        header("Location:../booking.php?success");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        header("Location:../booking.php?booking_error");
        exit();
    }
}
