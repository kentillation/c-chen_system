<?php
include "../../config.php";
session_start();

// Send email using PHPMailer library
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['email']) && isset($_POST['user_name']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $email = validate($_POST['email']);
    $user_name = validate($_POST['user_name']);
    $password = validate($_POST['password']);
    $firstname = "first_name";
    $middlename = "middle_name";
    $lastname = "last_name";
    date_default_timezone_set('Asia/Manila');
    $created_at = date("F j, Y | l - h : i : s a");
    $updated_at = date("F j, Y | l - h : i : s a");
    $img_url = "profile-img.png";

    $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE user_name = ? ");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        header("Location: ../../admin-signup.php?registered");
        exit();
    } else {

        $password = md5($password);
        $stmt = $conn->prepare("INSERT INTO tbl_admin (email, user_name, password, firstname, middlename, lastname, img_url, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");
        $stmt->bind_param('sssssssss', $email, $user_name, $password, $firstname, $middlename, $lastname, $img_url, $created_at, $updated_at);
        $stmt->execute();
        $result = $stmt->get_result();

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
            $datetime = date("F j, Y - l") . " | " . date("h : i : s a");
            $recipient = 'kentanthony2022@gmail.com';
            $subject = 'Admin account Creation';
            $message = "New Account has been added to the system on $datetime. \n \n";
            $message .= "Email: " . $email . "\n";
            $message .= "Username: " . $user_name . "\n";
            $message .= "Password: " . $password . "\n \n";
            $message .= "Note: Make sure to save the credentials for future purposes.";
            $mail->setFrom('christianschool.main@gmail.com', 'Dreamers');
            $mail->addAddress($recipient);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
        }

        header("Location: ../../admin-signup.php?success");
        exit();
    }
} else {
    header("Location: ../../signout");
    exit();
}
