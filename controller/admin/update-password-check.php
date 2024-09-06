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
    if (isset($_POST['current_password']) && isset($_POST['newpassword']) && isset($_POST['renewpassword'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id = validate($_SESSION['id']);
        $current_password = validate($_POST['current_password']);
        $current_password = md5($current_password);
        $newpassword = validate($_POST['newpassword']);
        $renewpassword = validate($_POST['renewpassword']);
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("F j, Y | l - h:i:sa");

        $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE id = ? ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $password = $row['password'];
        $email = $row['email'];

        if ($current_password !== $password) {
            header("Location: ../../views/admin/profile?invalid_current_password");
            exit();
        } else {
            if ($renewpassword !== $newpassword) {
                header("Location: ../../views/admin/profile?mismatch_passwords");
                exit();
            } else {
                $_newpassword = '<h1>' . $newpassword . '</h1>';
                $newpassword = md5($newpassword);
                $verification_code = rand(100000, 999999);
                $_verification_code = '<h1>' . $verification_code . '</h1>';
                $note = '<h1>PLEASE DO NOT SHARE IT WITH ANYONE.</h1>';
?>
                <!DOCTYPE html>
                <html>

                <body>
                    <?php echo $_verification_code; ?>
                    <?php echo $note; ?>
                </body>

                </html>
<?php

                $stmt = $conn->prepare(" INSERT INTO tbl_a_verification_code (verification_code, newpassword) VALUE (?, ?) ");
                $stmt->bind_param('is', $verification_code, $newpassword);
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

                    // Set email content type to HTML
                    $mail->isHTML(true);

                    // Email content
                    date_default_timezone_set('Asia/Manila');
                    $datetime = date("F j, Y - l") . " | " . date("h:i:sa");
                    $subject = 'Kent App | Verification Code';
                    $message = "Below are your credentials for changing new password. </br></br>";
                    $message .= "Verification Code: " . $_verification_code . "<br>";
                    $message .= "New Password: " . $_newpassword . "<br><br>";
                    $message .= "$note </br><br>";
                    $message .= "Note: This is a system-generated email. Please do not reply!";
                    $mail->setFrom('christianschool.main@gmail.com', 'Kent App');
                    $mail->addAddress($email);
                    $mail->Subject = $subject;
                    $mail->Body = $message;
                    $mail->send();
                } catch (Exception $e) {
                    echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
                }

                header("Location: ../../views/admin/change-password");
                exit();
            }
        }
    } else {
        header("Location: ../../views/admin/profile?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
