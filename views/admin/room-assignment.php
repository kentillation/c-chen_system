<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
  $booking_id = $_GET['bookind_id'];
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include 'includes/head.php' ?>
  </head>

  <body>

    <?php include 'includes/header.php' ?>
    <?php include 'includes/aside.php' ?>

    <main id="main" class="main">

      <div class="pagetitle">
        <h1>Room Assignment</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Main</li>
            <li class="breadcrumb-item active">Room Assignment</li>
          </ol>
        </nav>
      </div>

      <section class="section dashboard mb-5">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <?php
                $stmt = $conn->prepare(' SELECT
                  tbl_bookings.booking_id,
                  tbl_bookings.reference_number,
                  tbl_bookings.fullname,
                  tbl_bookings.email,
                  tbl_bookings.phone_number,
                  tbl_bookings.date_check_in,
                  tbl_bookings.date_check_out,
                  tbl_bookings.message,
                  tbl_mode_of_payment.mode_of_payment,
                  tbl_bookings.evidence,
                  tbl_bookings.booking_status_id,
                  tbl_bookings.created_at
                  FROM tbl_bookings
                  INNER JOIN tbl_mode_of_payment ON tbl_bookings.mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
                  WHERE tbl_bookings.booking_id = ?
                  ORDER BY tbl_bookings.created_at ASC');
                $stmt->bind_param('i', $booking_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $fullname = $row['fullname'];
                  $email = $row['email'];
                  $phone_number = $row['phone_number'];
                  $date_check_in = $row['date_check_in'];
                  $date_check_out = $row['date_check_out'];
                  $message = $row['message'];
                  $mode_of_payment = $row['mode_of_payment'];
                  $evidence = $row['evidence'];
                  $booking_status_id = $row['booking_status_id'];
                  $created_at = $row['created_at'];
                  $reference_number = $row['reference_number'];
                  if ($booking_status_id == 1) {
                    $status = "Pending";
                    $style = "class='text-danger'";
                    $visibility = "flex;";
                  } else if ($booking_status_id == 2) {
                    $status = "Confirmed";
                    $style = "class='text-primary'";
                    $visibility = "none;";
                  } else {
                    $status = "Decline";
                    $style = "class='text-warning'";
                  }
                ?>
                  <form action="../../controller/admin/confirm-with-rooms-booking.php?booking_id=<?= $booking_id ?>" method="post" class="container p-4">
                    <div class="row">
                      <div class="mt-2 col-12 col-lg-6 col-md-6 col-sm-6">
                        <h6 class="text-secondary">Date check-in: </h6>
                        <p><?= $date_check_in ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-6 col-sm-6">
                        <h6 class="text-secondary">Date check-out: </h6>
                        <p><?= $date_check_out ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Customer name: </h6>
                        <p><?= $fullname ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Email: </h6>
                        <p><?= $email ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Phone number: </h6>
                        <p><?= $phone_number ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Message: </h6>
                        <p><?= $message ?></p>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Receipt: </h6>
                        <img src="../../evidence/<?= $evidence ?>" width="250" height="250" alt="Evidence">
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Mode of payment: </h6>
                        <p><?= $mode_of_payment ?></p>
                      </div>
                      <div class="mt-3 col-12 col-lg-6 col-md-6 col-sm-12">
                        <h6 class="text-secondary">Cottages: </h6>
                        <div class="d-flex flex-column">
                          <?php
                          $stmtCottage = $conn->prepare('SELECT 
                              tbl_booking_cottage.booking_id,
                              tbl_cottages.cottage_name
                              FROM tbl_booking_cottage
                              INNER JOIN tbl_cottages ON tbl_booking_cottage.cottage_id = tbl_cottages.cottage_id
                              WHERE tbl_booking_cottage.booking_id = ?
                              ORDER BY tbl_booking_cottage.booking_id ');
                          $stmtCottage->bind_param('i', $booking_id);
                          $stmtCottage->execute();
                          $resultCottage = $stmtCottage->get_result();
                          while ($rowCottage = $resultCottage->fetch_assoc()) {
                            $cottage_name = $rowCottage['cottage_name'];
                          ?>
                            <span><i class="bi bi-check"></i>&nbsp; <?= $cottage_name ?></span>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="mt-3 col-12 col-lg-6 col-md-6 col-sm-12">
                        <h6 class="text-secondary">Other services: </h6>
                        <div class="d-flex flex-column">
                          <?php
                          $stmtOthers = $conn->prepare('SELECT 
                              tbl_booking_service.booking_id,
                              tbl_services.service_name
                              FROM tbl_booking_service
                              INNER JOIN tbl_services ON tbl_booking_service.service_id = tbl_services.service_id
                              WHERE tbl_booking_service.booking_id = ?
                              ORDER BY tbl_booking_service.booking_id ');
                          $stmtOthers->bind_param('i', $booking_id);
                          $stmtOthers->execute();
                          $resultOthers = $stmtOthers->get_result();
                          while ($rowOthers = $resultOthers->fetch_assoc()) {
                            $service_name = $rowOthers['service_name'];
                          ?>
                            <span><i class="bi bi-check"></i>&nbsp; <?= $service_name ?></span>
                          <?php
                          }
                          ?>
                        </div>
                      </div>
                      <!-- <div class="my-4 col-12 col-lg-6 col-md-6 col-sm-12">
                          <h6><span class="text-secondary">Status: </span><span <?= $style ?>><?= $status ?></span></h6>
                        </div> -->
                      <div class="mt-3 col-12 col-lg-12 col-md-12 col-sm-12">
                        <h6 class="text-secondary">Rooms: </h6>
                        <div class="d-flex flex-column">
                          <?php
                          $stmtBookingRooms = $conn->prepare('SELECT 
                          tbl_booking_room.booking_id,
                          tbl_booking_room.pax,
                          tbl_room_category.room_category_id,
                          tbl_room_category.room_category_name
                          FROM tbl_booking_room
                          INNER JOIN tbl_room_category ON tbl_booking_room.room_category_id = tbl_room_category.room_category_id
                          WHERE tbl_booking_room.booking_id = ?
                          ORDER BY tbl_booking_room.booking_id ');
                          $stmtBookingRooms->bind_param('i', $booking_id);
                          $stmtBookingRooms->execute();
                          $resultBookingRooms = $stmtBookingRooms->get_result();
                          $x = 1;
                          while ($rowBookingRooms = $resultBookingRooms->fetch_assoc()) {
                            $room_category_name = $rowBookingRooms['room_category_name'];
                            $pax = $rowBookingRooms['pax'];
                            $room_category_id = $rowBookingRooms['room_category_id'];
                            for ($i = 1; $i <= $pax; $i++) {
                          ?>
                              <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <p class="w-100 mt-2"><?= $x++ ?>.) &nbsp; <?= htmlspecialchars($room_category_name) ?>: </p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                  <select name="room_number[]" class="form-select">
                                    <option selected disabled>-select room #-</option>
                                    <?php
                                    $stmtRoomsCategory = $conn->prepare('SELECT 
                                    tbl_room_number.room_number_id,
                                    tbl_room_number.room_number
                                    FROM tbl_room_category
                                    INNER JOIN tbl_room_number ON tbl_room_category.room_category_id = tbl_room_number.room_category_id
                                    WHERE tbl_room_category.room_category_id = ?
                                    ORDER BY tbl_room_category.room_category_id ');
                                    $stmtRoomsCategory->bind_param('i', $room_category_id);
                                    $stmtRoomsCategory->execute();
                                    $resultRoomsCategory = $stmtRoomsCategory->get_result();
                                    while ($rowRoomsCategory = $resultRoomsCategory->fetch_assoc()) {
                                      $room_number_id = $rowRoomsCategory['room_number_id'];
                                      $room_number = $rowRoomsCategory['room_number'];
                                    ?>
                                      <option value="<?= htmlspecialchars($room_number_id) ?>"><?= htmlspecialchars($room_number) ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                                <hr class="mt-2">
                              </div>
                          <?php
                            }
                          }
                          ?>

                        </div>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-success mt-4 px-3 rounded-5 ms-1" type="submit" id="confirmBtn" style="display: <?= $visibility ?>">
                      <i class="bi bi-check"></i>&nbsp; Confirm
                    </button>
                  </form>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include 'includes/footer.php' ?>

    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/main.js"></script>
  </body>

  </html>
<?php

} else {
  header('Location: ../../signout.php');
  exit();
}
?>