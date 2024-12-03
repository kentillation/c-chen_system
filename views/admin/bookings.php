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
                                            tbl_bookings.booking_id,
                                            tbl_bookings.reference_number,
                                            tbl_bookings.fullname,
                                            tbl_bookings.email,
                                            tbl_bookings.phone_number,
                                            tbl_bookings.date_check_in,
                                            tbl_bookings.date_check_out,
                                            tbl_bookings.message,
                                            tbl_bookings.reason_for_cancellation,
                                            tbl_mode_of_payment.mode_of_payment,
                                            tbl_bookings.evidence,
                                            tbl_bookings.booking_status_id,
                                            tbl_bookings.created_at
                                            FROM tbl_bookings
                                            INNER JOIN tbl_mode_of_payment ON tbl_bookings.mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
                                            ORDER BY tbl_bookings.created_at ASC');
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $booking_id = $row['booking_id'];
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
                                                $reason_for_cancellation = $row['reason_for_cancellation'];

                                                if ($booking_status_id == 1) {
                                                    $status = "Pending";
                                                    $style = "class='text-warning'";
                                                    $cnfrmBtn = "flex;";
                                                    $cnclCnfrmtnBtn = "none;";
                                                    $reason = "none";
                                                } else if ($booking_status_id == 2) {
                                                    $status = "Confirmed";
                                                    $style = "class='text-success'";
                                                    $cnfrmBtn = "none;";
                                                    $cnclCnfrmtnBtn = "flex;";
                                                    $reason = "none";
                                                } else if ($booking_status_id == 3) {
                                                    $status = "Decline";
                                                    $style = "class='text-danger'";
                                                    $cnfrmBtn = "none;";
                                                    $cnclCnfrmtnBtn = "none;";
                                                    $reason = "none";
                                                } else if ($booking_status_id == 4) {
                                                    $status = "Cancelled";
                                                    $style = "class='text-warning'";
                                                    $cnfrmBtn = "flex;";
                                                    $cnclCnfrmtnBtn = "none;";
                                                    $reason = "block";
                                                }
                                                echo "
                                                <tr>
                                                    <td>$fullname</td>
                                                    <td>$email</td>
                                                    <td>$phone_number</td>
                                                    <td>$created_at</td>
                                                    <td class='text-center'><span $style>$status</span></td>
                                                    <td class='text-center'>
                                                        <button class='btn btn-sm btn-primary rounded-5' data-bs-toggle='modal' data-bs-target='#infoModal$booking_id'>
                                                            <i class='bi bi-eye'></i>&nbsp; <span class='to-hide'>View</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                ";
                                            ?>
                                                <div class="modal fade" id="infoModal<?= $booking_id ?>" aria-hidden="true" tabindex="-1">
                                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                                        <form action="../../controller/admin/confirm-booking.php?booking_id=<?= $booking_id ?>" method="post">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Booking details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6">
                                                                            <h6 class="text-secondary">Date check-in: </h6>
                                                                            <p><?= $date_check_in ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6">
                                                                            <h6 class="text-secondary">Date check-out: </h6>
                                                                            <p><?= $date_check_out ?></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
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
                                                                            <h6 class="text-secondary">Receipt: </h6>
                                                                            <img src="../../evidence/<?= $evidence ?>" width="250" height="250" alt="Evidence">
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                                                            <h6 class="text-secondary">Mode of payment: </h6>
                                                                            <p><?= $mode_of_payment ?></p>
                                                                        </div>
                                                                        <div class="mt-2 col-12 col-lg-4 col-md-4 col-sm-6">
                                                                            <h6 class="text-secondary">Message: </h6>
                                                                            <textarea cols="30" row="30" class="form-control"><?= $message ?></textarea>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6">
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
                                                                            <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6">
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
                                                                            <div class="mt-2 col-12 col-lg-4 col-md-6 col-sm-6">
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
                                                                        </div>
                                                                        <div class="mt-3 text-end">
                                                                            <h6><span class="text-secondary">Status: </span><span <?= $style ?>><?= $status ?></span></h6>
                                                                            <h6 style="display: <?=$reason?>;"><span class="text-secondary">Reason: <br /></span><?= $reason_for_cancellation ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer d-flex justify-content-between">
                                                                    <div>
                                                                        <?php
                                                                        $stmt = $conn->prepare("SELECT * FROM tbl_booking_room WHERE booking_id = ?");
                                                                        $stmt->bind_param('i', $booking_id);
                                                                        $stmt->execute();
                                                                        $result = $stmt->get_result();
                                                                        if ($result->num_rows > 0) {
                                                                            $assignRmBtn = "flex;";
                                                                        } else {
                                                                            $assignRmBtn = "none;";
                                                                        }
                                                                        ?>
                                                                        <a href="room-assignment.php?booking_id=<?= $booking_id ?>" style="display: <?= $assignRmBtn ?>">
                                                                            <button class="btn btn-sm btn-primary px-3 rounded-5" type="button">
                                                                                <i class="bi bi-pin"></i>&nbsp; Assign Room
                                                                            </button>
                                                                        </a>
                                                                        <button style="display: <?= $cnclCnfrmtnBtn ?>" onclick="redirectToCancel()" class="btn btn-sm btn-primary px-3 rounded-5" type="button">
                                                                            <i class="bi bi-exclamation-triangle"></i>&nbsp; Want to cancel confirmation?
                                                                        </button>
                                                                    </div>
                                                                    <div class="d-flex">
                                                                        <button class="btn btn-sm btn-danger px-3 rounded-5" type="button" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="bi bi-x"></i>&nbsp; Close
                                                                        </button>
                                                                        <button class="btn btn-sm btn-success px-3 rounded-5 ms-1" type="submit" style="display: <?= $cnfrmBtn ?>">
                                                                            <i class="bi bi-check"></i>&nbsp; Confirm
                                                                        </button>
                                                                    </div>
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
        <script>
        function redirectToCancel() {
            const bookingId = <?= json_encode($booking_id) ?>;
            const url = `cancel-confirmed-booking.php?booking_id=${bookingId}`;
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