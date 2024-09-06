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
    if (isset($_POST['verification_code'])) {
        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id = validate($_SESSION['id']);
        $verification_code = validate($_POST['verification_code']);
        date_default_timezone_set('Asia/Manila');
        $updated_at = date("F j, Y | l - h:i:sa");

        $stmt = $conn->prepare(" SELECT * FROM tbl_a_verification_code WHERE id = ? AND verification_code = ?");
        $stmt->bind_param("ii", $id, $verification_code);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $newpassword = $row['newpassword'];
            $message_content = "You have successfully changed your password. </br>";
            $note = '<h1>PLEASE DO NOT SHARE IT WITH ANYONE.</h1>';
?>
            <!DOCTYPE html>
            <html>

            <body>
                <?php echo $message_content; ?>
                <?php echo $note; ?>
            </body>

            </html>
<?php

            $stmt = $conn->prepare(" UPDATE tbl_admin SET password = ?, updated_at = ? WHERE id = ? ");
            $stmt->bind_param('ssi', $newpassword, $updated_at, $id);
            $stmt->execute();

            $stmt = $conn->prepare(" SELECT * FROM tbl_admin WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
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

                // Set email content type to HTML
                $mail->isHTML(true);

                // Email content
                date_default_timezone_set('Asia/Manila');
                $datetime = date("F j, Y - l") . " | " . date("h:i:sa");
                $subject = "Kent's App | Password Changed";
                $message = $message_content;
                $message .= "$note </br><br>";
                $message .= "Note: This is a system-generated email. Please do not reply!";
                $mail->setFrom('christianschool.main@gmail.com', "Kent's App");
                $mail->addAddress($email);
                $mail->Subject = $subject;
                $mail->Body = $message;
                $mail->send();
            } catch (Exception $e) {
                echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
            }

            $stmt = $conn->prepare(" DELETE FROM tbl_a_verification_code WHERE id = ? AND verification_code = ?");
            $stmt->bind_param("ii", $id, $verification_code);
            $stmt->execute();

            header("Location: ../../admin-login?password_changed");
            exit();
        } else {
            header("Location: ../../views/admin/change-password?verification_error");
            exit();
        }
    } else {
        header("Location: ../../views/admin/change-password?unknown");
        exit();
    }
} else {
    header('Location: ../../signout');
    exit();
}
