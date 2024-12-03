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
        <a href="bookings.php">
          <i class="bi bi-arrow-left"></i>&nbsp; Back
        </a>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <?php
                $stmt = $conn->prepare(' SELECT
                  tbl_bookings.booking_id,
                  tbl_bookings.reference_number
                  FROM tbl_bookings
                  WHERE tbl_bookings.booking_id = ?');
                $stmt->bind_param('i', $booking_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                  $row = $result->fetch_assoc();
                  $reference_number = $row['reference_number'];
                ?>
                  <form action="../../controller/admin/confirm-with-rooms-booking.php?booking_id=<?= $booking_id ?>" method="post" class="container p-4">
                    <div class="row">
                      <div class="mt-2 col-12 col-lg-6 col-md-4 col-sm-6">
                        <h6 class="text-secondary">Reference #: </h6>
                        <p><?= $reference_number ?></p>
                      </div>
                      <div class="mt-4 col-12 col-lg-12 col-md-12 col-sm-12">
                        <h6 class="text-secondary">Rooms: </h6>
                        <div class="d-flex flex-column">
                          <?php
                          $stmtBookingRooms = $conn->prepare('SELECT 
                          tbl_booking_room.booking_id,
                          tbl_booking_room.booking_room_id,
                          tbl_booking_room.pax,
                          tbl_booking_room.room_number,
                          tbl_room_category.room_category_id,
                          tbl_room_category.room_category_name
                          FROM tbl_booking_room
                          INNER JOIN tbl_room_category ON tbl_booking_room.room_category_id = tbl_room_category.room_category_id
                          WHERE tbl_booking_room.booking_id = ?
                          ORDER BY tbl_booking_room.booking_room_id ASC');
                          $stmtBookingRooms->bind_param('i', $booking_id);
                          $stmtBookingRooms->execute();
                          $resultBookingRooms = $stmtBookingRooms->get_result();
                          $x = 1;
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
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                  <p class="w-100 mt-2"><?= $x++ ?>.) &nbsp; <?= htmlspecialchars($room_category_name) ?>: </p>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                  <input type="hidden" name="room_category_id[]" value="<?= $room_category_id ?>">
                                  <select name="room_number[<?= $room_category_id ?>][]" class="form-select">
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
                                <hr class="mt-2">
                              </div>
                          <?php
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-sm btn-success mt-4 px-3 py-2 rounded-5 ms-1" type="submit" id="confirmBtn">
                      <i class="bi bi-check"></i>&nbsp; Save and Confirm
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
  </body>

  </html>
<?php

} else {
  header('Location: ../../signout.php');
  exit();
}
?>