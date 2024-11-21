<?php
include '../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (
    isset($_FILES['evidence']) && isset($_POST['fullname']) && isset($_POST['email']) &&
    isset($_POST['phone_number']) && isset($_POST['date_check_in']) &&
    isset($_POST['date_check_out']) && isset($_POST['service_id']) &&
    isset($_POST['message']) && isset($_POST['mode_of_payment_id'])
) {
    // Helper function to validate input data
    function validate($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }
    // Validate and sanitize all input fields
    $fullname = validate($_POST['fullname']);
    $email = validate($_POST['email']);
    $phone_number = validate($_POST['phone_number']);
    $date_check_in = validate($_POST['date_check_in']);
    $date_check_out = validate($_POST['date_check_out']);
    $message = validate($_POST['message']);
    $mode_of_payment_id = validate($_POST['mode_of_payment_id']);
    $evidence = $_FILES['evidence'];
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location:../booking.php?invalid_email");
        exit();
    }
    // Check if the evidence file was uploaded without errors
    if ($evidence['error'] === 0) {
        // Check file size (limit to 10MB below)
        if ($evidence['size'] > 10000000) {
            header("Location:../booking.php?too_large");
            exit();
        }
        // Allowed file extensions
        $allowed_exs = ['jpg', 'jpeg', 'png'];
        $img_ex = pathinfo($evidence['name'], PATHINFO_EXTENSION);
        $img_ex_lc = strtolower($img_ex);
        if (in_array($img_ex_lc, $allowed_exs)) {
            // Generate unique filename for the evidence file
            $new_evidence = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = '../evidence/' . $new_evidence;
            move_uploaded_file($evidence['tmp_name'], $img_upload_path);
            // Check if service_id is an array and insert each service as a separate row
            $service_ids = is_array($_POST['service_id']) ? $_POST['service_id'] : [$_POST['service_id']];
            $success = true;
            function generateReferenceNumber($length = 10)
            {
                $referenceNumber = '';
                for ($i = 0; $i < $length; $i++) {
                    $referenceNumber .= mt_rand(0, 9);
                }
                return $referenceNumber;
            }
            $referenceNumber = generateReferenceNumber();
            foreach ($service_ids as $service_id) {
                $service_id = validate($service_id);
                $booking_status_id = 1;
                // Insert each service into `tbl_bookings`
                $stmt = $conn->prepare('INSERT INTO tbl_bookings (reference_number, fullname, email, phone_number, date_check_in, date_check_out, service_id, message, mode_of_payment_id, evidence, booking_status_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->bind_param('ssssssisisi',$referenceNumber,$fullname, $email, $phone_number, $date_check_in, $date_check_out, $service_id, $message, $mode_of_payment_id, $new_evidence, $booking_status_id);

                if (!$stmt->execute()) {
                    $success = false;
                    break;
                }
            }
            if ($success) {
                // Insert data into `tbl_schedule` once after all services are successfully booked
                $stmt_schedule = $conn->prepare('INSERT INTO tbl_schedule (fullname, description, start_datetime, end_datetime) VALUES (?, ?, ?, ?)');
                $stmt_schedule->bind_param('ssss', $fullname, $message, $date_check_in, $date_check_out);
                if ($stmt_schedule->execute()) {
                    header("Location:../booking.php?success");
                    exit();
                } else {
                    header("Location:../booking.php?schedule_error");
                    exit();
                }
            } else {
                header("Location:../booking.php?booking_error");
                exit();
            }
        } else {
            header("Location:../booking.php?wrong_file_type");
            exit();
        }
    } else {
        header("Location:../booking.php?upload_error");
        exit();
    }
} else {
    header("Location:../booking.php?missing_data");
    exit();
}
