<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
  $booking_id = $_GET['booking_id'];
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
        <a href="booking-details.php?booking_id=<?= $booking_id ?>">
          <i class="bi bi-arrow-left"></i>&nbsp; Back
        </a>
        <div class="row">
          <div class="col-lg-8">
            <?php
            if (isset($_GET['updated'])) {
            ?>
              <div class="mt-2 alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                <span><?php echo $_GET['updated'], "Booking has been updated successfully!"; ?></span>
                <a href="#">
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
              </div>
            <?php
            }
            ?>
            <div class="card">
              <div class="card-body">
                <?php
                $stmtBookings1 = $conn->prepare(" SELECT * FROM tbl_bookings 
                WHERE booking_id = ? ");
                $stmtBookings1->bind_param('i', $booking_id);
                $stmtBookings1->execute();
                $resultBookings1 = $stmtBookings1->get_result();
                if ($resultBookings1->num_rows > 0) {
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
                  $stmt = $conn->prepare(" SELECT t_b.*,
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
                  $down_payment = $row['down_payment'];
                  $evidence = $row['evidence'];
                  $room = ($room_payment ?? 0) * $days;
                  $service = ($service_payment ?? 0) * $days;
                  $total_payment = $room + $cottage_payment + $service;
                  $remaining_balance = $total_payment - $down_payment;
                  if ($down_payment == $total_payment) {
                    $cnfrmChckIn = "block;";
                  } else {
                    $cnfrmChckIn = "none;";
                  }
                ?>
                  <form action="../../controller/admin/confirm-with-rooms-booking.php?booking_id=<?= $booking_id ?>" method="post" class="container p-4">
                    <div class="row">
                      <div class="mt-2 col-12 col-lg-12 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Booking #:</h6>
                        <h6 class="text-secondary"><span class="text-dark"><?= $reference_number ?></span></h6>
                      </div>
                      <div class="mt-4 col-12 col-lg-12 col-md-12 col-sm-12">
                        <h6 class="text-secondary">Rooms: </h6>
                        <div class="d-flex flex-column">
                          <?php
                          $stmtBookingRooms = $conn->prepare('SELECT 
                          t_br.booking_id,
                          t_br.booking_room_id,
                          t_br.pax,
                          t_br.room_number,
                          trc.room_category_id,
                          trc.room_category_name
                          FROM tbl_booking_room t_br
                          INNER JOIN tbl_room_category trc ON t_br.room_category_id = trc.room_category_id
                          WHERE t_br.booking_id = ?
                          ORDER BY t_br.booking_room_id ASC');
                          $stmtBookingRooms->bind_param('i', $booking_id);
                          $stmtBookingRooms->execute();
                          $resultBookingRooms = $stmtBookingRooms->get_result();
                          while ($rowBookingRooms = $resultBookingRooms->fetch_assoc()) {
                            $room_category_name = $rowBookingRooms['room_category_name'];
                            $pax = $rowBookingRooms['pax'];
                            $rm_nmbr = $rowBookingRooms['room_number'];
                            $room_category_id = $rowBookingRooms['room_category_id'];
                            for ($i = 1; $i <= $pax; $i++) {
                              $stmtRoomsCategory = $conn->prepare('SELECT * FROM tbl_room_number WHERE room_category_id = ?');
                              $stmtRoomsCategory->bind_param('i', $room_category_id);
                              $stmtRoomsCategory->execute();
                              $resultRoomsCategory = $stmtRoomsCategory->get_result();
                          ?>
                              <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex">
                                  <p class="w-100 mt-2"><?= htmlspecialchars($room_category_name) ?>: </p>
                                  <input type="hidden" name="room_category_id[]" value="<?= $room_category_id ?>">
                                  <select name="room_number[<?= $room_category_id ?>][]" class="form-select" required>
                                    <?php
                                    if (!empty($rm_nmbr)) {
                                    ?>
                                      <option value="<?= htmlspecialchars($rm_nmbr) ?>"><?= htmlspecialchars($rm_nmbr) ?></option>
                                    <?php
                                    } else {
                                    ?>
                                      <option selected disabled>-select room #-</option>
                                    <?php
                                    }
                                    while ($rowRoomsCategory = $resultRoomsCategory->fetch_assoc()) {
                                      $room_number = $rowRoomsCategory['room_number'];
                                    ?>
                                      <option value="<?= htmlspecialchars($room_number) ?>"><?= htmlspecialchars($room_number) ?></option>
                                    <?php
                                    }
                                    ?>
                                  </select>
                                </div>
                                <div class="mt-3"></div>
                              </div>
                          <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-6 col-sm-6">
                        <h6 class="text-secondary">Payment receipt:</h6>
                        <img src="../../evidence/<?= $evidence ?>" width="250" height="250" alt="Evidence">
                      </div>
                      <div class="mt-2 col-12 col-lg-6 col-md-6 col-sm-6">
                        <div class="row gy-3">
                          <div class="col-12">
                            <h6 class="text-secondary">Total payment:</h6>
                            <input type="text" value="<?= $total_payment ?>" class="form-control" readonly>
                          </div>
                          <div class="col-12">
                            <h6 class="text-secondary">Down payment:</h6>
                            <input type="text" name="down_payment" value="<?= $down_payment ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" required>
                          </div>
                          <div class="col-12">
                            <h6 class="text-secondary">Remaining balance:</h6>
                            <input type="text" value="<?= $remaining_balance ?>" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex mt-4">
                      <button class="btn btn-primary px-3 py-2 rounded-5 ms-1" type="submit" id="confirmBtn">
                        <i class="bi bi-check"></i>&nbsp; Save
                      </button>
                      <button class="btn btn-primary px-3 py-2 rounded-5 ms-1" style="display: <?= $cnfrmChckIn ?>" data-bs-toggle="modal" data-bs-target="#conFirmCheckin" type="button">
                        <i class="bi bi-arrow-return-right"></i>&nbsp; Check-in
                      </button>
                    </div>
                  </form>
                <?php
                }
                ?>
              </div>
              <div class="modal fade" tabindex="-1" id="conFirmCheckin">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-4">
                      <p class="text-center">Are you sure the guest will check in right now?</p>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-danger rounded-2 px-3 py-1" data-bs-dismiss="modal" aria-label="Close">
                        <i class="bi bi-x"></i>&nbsp; Cancel
                      </button>
                      <button onclick="confirmCheckIn()" type="button" class="btn-primary text-white rounded-2 px-3 py-1">
                        <i class="bi bi-check"></i>&nbsp; Yes
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include 'includes/footer.php' ?>
    <?php include 'includes/scripts.php' ?>
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const roomNumberDropdowns = document.querySelectorAll('select[name="room_number[]"]');
        roomNumberDropdowns.forEach(dropdown => {
          dropdown.addEventListener("change", function() {
            console.log(`Selected Room Number: ${this.value}`);
          });
        });
      });
    </script>
    <script>
      function confirmCheckIn() {
        const bookingId = <?= json_encode($booking_id) ?>;
        const url = `../../controller/admin/confirm-check-in.php?booking_id=${bookingId}`;
        window.location.href = url;
      }
    </script>
  </body>

  </html>
<?php

} else {
  header('Location: ../../signout.php');
  exit();
}
?>