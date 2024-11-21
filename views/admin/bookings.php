<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
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
                <h1>Bookings</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (isset($_GET['updated'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['updated'], "Booking has been confirmed successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-4">
                                    <table class="table" id="paginateAllOrders">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="15%">
                                        <col width="20%">
                                        <col width="15%">
                                        <col width="10%">
                                        <thead>
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Email</th>
                                                <th>Phone #</th>
                                                <th>Booking date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare(' SELECT
                                            tbl_bookings.id,
                                            tbl_bookings.reference_number,
                                            tbl_bookings.fullname,
                                            tbl_bookings.email,
                                            tbl_bookings.phone_number,
                                            tbl_bookings.date_check_in,
                                            tbl_bookings.date_check_out,
                                            tbl_services.service_name,
                                            tbl_bookings.message,
                                            tbl_mode_of_payment.mode_of_payment,
                                            tbl_bookings.evidence,
                                            tbl_bookings.booking_status_id,
                                            tbl_bookings.created_at
                                            FROM tbl_bookings
                                            INNER JOIN tbl_services ON tbl_bookings.service_id = tbl_services.service_id
                                            INNER JOIN tbl_mode_of_payment ON tbl_bookings.mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
                                            GROUP BY tbl_bookings.reference_number
                                            ORDER BY tbl_bookings.created_at ASC');
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                $fullname = $row['fullname'];
                                                $email = $row['email'];
                                                $phone_number = $row['phone_number'];
                                                $date_check_in = $row['date_check_in'];
                                                $date_check_out = $row['date_check_out'];
                                                $service_name = $row['service_name'];
                                                $message = $row['message'];
                                                $mode_of_payment = $row['mode_of_payment'];
                                                $evidence = $row['evidence'];
                                                $booking_status_id = $row['booking_status_id'];
                                                $created_at = $row['created_at'];
                                                $reference_number = $row['reference_number'];

                                                if ($booking_status_id == 1) {
                                                    $status = "Pending";
                                                    $style = "class='text-danger'";
                                                } else if ($booking_status_id == 2) {
                                                    $status = "Confirmed";
                                                    $style = "class='text-primary'";
                                                } else {
                                                    $status = "Decline";
                                                    $style = "class='text-warning'";
                                                }
                                                echo "
                                                <tr>
                                                    <td>$fullname</td>
                                                    <td>$email</td>
                                                    <td>$phone_number</td>
                                                    <td>$created_at</td>
                                                    <td class='text-center'><span $style>$status</span></td>
                                                    <td class='text-center'>
                                                        <button class='btn btn-sm btn-primary rounded-5' data-bs-toggle='modal' data-bs-target='#infoModal$id'>
                                                            <i class='bi bi-eye'></i>&nbsp; <span class='to-hide'>View</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                ";
                                            ?>
                                                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="infoModal<?= $id ?>">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                                        <form action="../../controller/admin/confirm-booking.php?booking_id=<?= $id ?>" method="post">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Customer details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Full name</h6>
                                                                            <p><?= $fullname ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Email</h6>
                                                                            <p><?= $email ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Phone number</h6>
                                                                            <p><?= $phone_number ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Date check-in</h6>
                                                                            <p><?= $date_check_in ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Date check-out</h6>
                                                                            <p><?= $date_check_out ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Service</h6>
                                                                            <p><?= $service_name ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-3 col-md-4 col-sm-12">
                                                                            <h6 class="text-secondary">Mode of payment</h6>
                                                                            <p><?= $mode_of_payment ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12">
                                                                            <div class="row">
                                                                                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                                                                                    <h6 class="text-secondary">Evidence (mode of payment)</h6>
                                                                                    <img src="../../evidence/<?= $evidence ?>" width="250" alt="Evidence">
                                                                                </div>
                                                                                <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <h6 class="text-secondary">Message</h6>
                                                                                            <textarea cols="30" row="10" class="form-control"><?= $message ?></textarea>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <h6 class="text-secondary">Room Numbers</h6>
                                                                                            <div class="d-flex">
                                                                                                <?php
                                                                                                $stmt_booking_room = $conn->prepare('SELECT 
                                                                                            tbl_booking_room.room_number_id,
                                                                                            tbl_booking_room.reference_number,
                                                                                            tbl_room_number.room_number
                                                                                            FROM tbl_booking_room
                                                                                            INNER JOIN tbl_room_number ON tbl_booking_room.room_number_id = tbl_room_number.room_number_id
                                                                                            WHERE tbl_booking_room.reference_number = ? ');
                                                                                                $stmt_booking_room->bind_param('s', $reference_number);
                                                                                                $stmt_booking_room->execute();
                                                                                                $result_booking_room = $stmt_booking_room->get_result();
                                                                                                while ($row_booking_room = $result_booking_room->fetch_assoc()) {
                                                                                                    $room_number = $row_booking_room['room_number'];
                                                                                                ?>
                                                                                                    <p><?= $room_number ?>, &nbsp;</p>
                                                                                                <?php
                                                                                                }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-2 text-end">
                                                                            <h6><span class="text-secondary">Status: </span><span <?= $style ?>><?= $status ?></span></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-sm btn-danger" type="button" data-bs-dismiss="modal">
                                                                        <i class="bi bi-x"></i>&nbsp; Close
                                                                    </button>
                                                                    <button class="btn btn-sm btn-primary" type="submit">
                                                                        <i class="bi bi-check"></i>&nbsp; Confirm
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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