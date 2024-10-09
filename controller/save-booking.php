<?php
include '../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ( isset($_FILES['evidence']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['phone_number']) &&
    isset($_POST['telephone_number']) && isset($_POST['date_check_in']) && isset($_POST['date_check_out']) && isset($_POST['service_id']) &&
    isset($_POST['message']) && isset($_POST['mode_of_payment_id'])

) {

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  $fullname = validate($_POST['fullname']);
  $email = validate($_POST['email']);
  $phone_number = validate($_POST['phone_number']);
  $telephone_number = validate($_POST['telephone_number']);
  $date_check_in = validate($_POST['date_check_in']);
  $date_check_out = validate($_POST['date_check_out']);
  $service_id = validate($_POST['service_id']);
  $message = validate($_POST['message']);
  $mode_of_payment_id = validate($_POST['mode_of_payment_id']);
  $evidence = $_FILES['evidence'];
  date_default_timezone_set('Asia/Manila');
  $updated_at = date("Y-m-d h:i:s");
  $img_name = $_FILES['evidence']['name'];
  $img_size = $_FILES['evidence']['size'];
  $tmp_name = $_FILES['evidence']['tmp_name'];
  $error = $_FILES['evidence']['error'];

  if ($error === 0) {
    if ($img_size > 1000000) {
      header("Location:../booking.php?too_large");
    } else {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);
      $allowed_exs = array("jpg", "jpeg", "png");
      if (in_array($img_ex_lc, $allowed_exs)) {
        $new_evidence = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $img_upload_path = '../evidence/' . $new_evidence;
        move_uploaded_file($tmp_name, $img_upload_path);

        $stmt = $conn->prepare(' INSERT INTO tbl_bookings (fullname, email, phone_number, telephone_number, date_check_in , date_check_out, service_id, message, mode_of_payment_id, evidence) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ');
        $stmt->bind_param('ssssssisis', $fullname, $email, $phone_number, $telephone_number, $date_check_in, $date_check_out, $service_id, $message, $mode_of_payment_id, $new_evidence);
        $stmt->execute();

        $stmt = $conn->prepare(' INSERT INTO tbl_schedule (fullname, description, start_datetime, end_datetime) VALUES (?, ?, ?, ?) ');
        $stmt->bind_param('ssss', $fullname,  $message, $date_check_in, $date_check_out);
        $stmt->execute();
        
        header("Location:../booking.php?success");
        exit();
      } else {
        header("Location:../booking.php?wrong_file_type");
        exit();
      }
    }
  }
} else {
  header("Location:../booking.php?unknown");
  exit();
}
