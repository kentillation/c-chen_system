<?php
include 'config.php';
session_start();
// Send email using PHPMailer library
require 'email-plugin/PHPMailer.php';
require 'email-plugin/SMTP.php';
require 'email-plugin/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$account_status = 2;
$stmt_students = $conn->prepare("SELECT * FROM tbl_student WHERE account_status = ?");
$stmt_students->bind_param('i', $account_status);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

$message_content = "<h3>Reminder!!!</h3></br></br>";
$message_content .= "<p>[INSERT PERSONALIZED ANNOUNCEMENT/NOTIFICATION]</p></br></br>";
$message_footer = "<a href='https://www.kentillation.com/'><button style='background: #7135a8; color: #f5e5ff; border: none; border-radius: 8px; padding: 10px; font-size: 15px;'>Login Now!</button></a>";
$message_footer .= "<p style='margin-top: 35px;'>This is a system-generated email. Please do not reply!</p></br>";

?>
        <!DOCTYPE html>
        <html>
        <body>
            <?php echo $message_content; ?>
            <?php echo $message_footer; ?>
        </body>
        </html>
<?php

while ($student_row = $result_students->fetch_assoc()) {
    $email = $student_row['email'];
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
        $subject = 'C-chen Paradise Beach Resort System | Announcement/Notification';
        $message = $message_content;
        $message .= $message_footer;
        $mail->setFrom('christianschool.main@gmail.com', "C-chen Paradise Beach Resort System");
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->send();
    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ', $mail->ErrorInfo;
    }
}

header('Location: views/admin/calendar');
exit;
