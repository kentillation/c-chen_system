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

if (!isset($_GET['id'])) {
    echo "<script> alert('Undefined Schedule ID.'); location.replace('./calendar') </script>";
    $conn->close();
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM schedule_list WHERE id = ? ");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$title = $row['title'];

$stmt = $conn->prepare(" SELECT * FROM tbl_student ");
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
        $subject = 'Poturo App | Event [Removed]';
        $message = "The event which entitled '$title' is already removed. \n \n \n";
        $message .= "Note: This is a system-generated email. Please do not reply!.";
        $mail->setFrom('christianschool.main@gmail.com', 'Poturo');
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
    }
}

$delete = $conn->query("DELETE FROM `schedule_list` where id = '{$_GET['id']}'");
if ($delete) {
    echo "<script> alert('Event has been deleted successfully.'); location.replace('./calendar') </script>";
} else {
    echo "<pre>";
    echo "An Error occured.<br>";
    echo "Error: " . $conn->error . "<br>";
    echo "SQL: " . $sql . "<br>";
    echo "</pre>";
}
$conn->close();
