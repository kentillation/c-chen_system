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
                <h1>Booking Details</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item">Bookings</li>
                        <li class="breadcrumb-item active">Booking Details</li>
                    </ol>
                </nav>
            </div>
            <section class="section dashboard mb-5">
                <a href="bookings.php">
                    <i class="bi bi-arrow-left"></i>&nbsp; Back
                </a>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $stmtBookings = $conn->prepare(' SELECT
                                            t_b.*,
                                            t_mop.mode_of_payment
                                            FROM tbl_bookings t_b
                                            INNER JOIN tbl_mode_of_payment t_mop ON t_b.mode_of_payment_id = t_mop.mode_of_payment_id
                                            WHERE t_b.booking_id = ?');
                                $stmtBookings->bind_param('i', $booking_id);
                                $stmtBookings->execute();
                                $resultBookings = $stmtBookings->get_result();
                                if ($resultBookings->num_rows > 0) {
                                    $rowBookings = $resultBookings->fetch_assoc();
                                    $booking_id = $rowBookings['booking_id'];
                                    $fullname = $rowBookings['fullname'];
                                    $email = $rowBookings['email'];
                                    $phone_number = $rowBookings['phone_number'];
                                    $date_check_in = (new DateTime($rowBookings['date_check_in']))->format("F j, Y");
                                    $date_check_out = (new DateTime($rowBookings['date_check_out']))->format("F j, Y");
                                    $message = $rowBookings['message'];
                                    $mode_of_payment = $rowBookings['mode_of_payment'];
                                    $down_payment = $rowBookings['down_payment'];
                                    if ($down_payment == 0) {
                                        $down_payment = "Not set";
                                        $dpClass = "text-danger";
                                    } else {
                                        $down_payment = "₱" . $down_payment;
                                        $dpClass = "text-dark";
                                    }
                                    $evidence = $rowBookings['evidence'];
                                    $booking_status_id = $rowBookings['booking_status_id'];
                                    $created_at = (new DateTime($rowBookings['created_at']))->format("F j, Y");
                                    $reference_number = $rowBookings['reference_number'];
                                    $reason_for_cancellation = $rowBookings['reason_for_cancellation'];
                                    if ($booking_status_id == 1) {
                                        $status = "Pending";
                                        $badge = "class='badge bg-warning'";
                                        $style = "class='text-warning'";
                                        $reason = "none";
                                    } else if ($booking_status_id == 2) {
                                        $status = "Confirmed";
                                        $badge = "class='badge bg-success'";
                                        $style = "class='text-success'";
                                        $reason = "none";
                                    } else if ($booking_status_id == 3) {
                                        $status = "Decline";
                                        $badge = "class='badge bg-danger'";
                                        $style = "class='text-danger'";
                                        $reason = "none";
                                    } else if ($booking_status_id == 4) {
                                        $status = "Cancelled";
                                        $badge = "class='badge bg-warning'";
                                        $style = "class='text-warning'";
                                        $reason = "block";
                                    }
                                }
                                ?>
                                <div class="p-3">
                                    <div class="row">
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Date check-in: </h6>
                                            <p><?= $date_check_in ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Date check-out: </h6>
                                            <p><?= $date_check_out ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Customer name: </h6>
                                            <p><?= $fullname ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Email: </h6>
                                            <p><?= $email ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Phone number: </h6>
                                            <p><?= $phone_number ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Message: </h6>
                                            <textarea cols="30" row="30" class="form-control"><?= $message ?></textarea>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Mode of payment: </h6>
                                            <p><?= $mode_of_payment ?></p>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Payment receipt: </h6>
                                            <img src="../../evidence/<?= $evidence ?>" width="250" height="250" alt="Evidence">
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                            <h6 class="text-secondary">Down payment: </h6>
                                            <p class="<?= $dpClass ?>"><?= $down_payment ?></p>
                                        </div>

                                        <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6 mt-3">
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
                                                    <span><?= $cottage_name ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6 mt-3">
                                            <h6 class="text-secondary">Rooms: </h6>
                                            <div class="d-flex flex-column">
                                                <?php
                                                $stmtRooms = $conn->prepare('SELECT 
                                                    tbl_booking_room.booking_id,
                                                    tbl_booking_room.room_category_id,
                                                    COUNT(tbl_booking_room.room_category_id) AS occupied_room,
                                                    tbl_room_category.room_category_name
                                                    FROM tbl_booking_room
                                                    INNER JOIN tbl_room_category ON tbl_booking_room.room_category_id = tbl_room_category.room_category_id
                                                    WHERE tbl_booking_room.booking_id = ?
                                                    GROUP BY tbl_booking_room.booking_id, tbl_booking_room.room_category_id
                                                    ORDER BY tbl_booking_room.booking_id ');
                                                $stmtRooms->bind_param('i', $booking_id);
                                                $stmtRooms->execute();
                                                $resultRooms = $stmtRooms->get_result();
                                                while ($rowRooms = $resultRooms->fetch_assoc()) {
                                                    $room_category_name = $rowRooms['room_category_name'];
                                                    $occupied_room = $rowRooms['occupied_room'];
                                                ?>
                                                    <span><?= $occupied_room . "&nbsp;" . $room_category_name ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 mt-3">
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
                                                    <span><?= $service_name ?></span>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4 col-md-6 col-sm-6 mt-3">
                                            <h6><span class="text-secondary">Status: </span><span <?= $style ?>><?= $status ?></span></h6>
                                            <h6 style="display: <?= $reason ?>;"><span class="text-secondary">Reason: <br /></span><?= $reason_for_cancellation ?></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <button onclick="assgnRm()" class="btn btn-sm btn-primary px-3 py-2 rounded-5 m-1" type="button">
                                        <i class="bi bi-pin"></i>&nbsp; Assign
                                    </button>
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
                </div>
            </section>

        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <?php include 'includes/footer.php' ?>
        <?php include 'includes/scripts.php' ?>
        <script>
            function assgnRm() {
                const bookingId = <?= json_encode($booking_id) ?>;
                const url = `./room-assignment.php?booking_id=${bookingId}`;
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