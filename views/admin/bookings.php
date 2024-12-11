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
                                <div class="table-responsive mt-4" id="data-table">
                                    <table class="table" id="paginateAllReservations">
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                        <col width="25%">
                                        <thead>
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Booking date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmtBookings = $conn->prepare(' SELECT
                                            tbl_bookings.*,
                                            tbl_mode_of_payment.mode_of_payment
                                            FROM tbl_bookings
                                            INNER JOIN tbl_mode_of_payment ON tbl_bookings.mode_of_payment_id = tbl_mode_of_payment.mode_of_payment_id
                                            ORDER BY tbl_bookings.created_at ASC');
                                            $stmtBookings->execute();
                                            $resultBookings = $stmtBookings->get_result();
                                            if ($resultBookings->num_rows > 0) {
                                                while ($rowBookings = $resultBookings->fetch_assoc()) {
                                                    $booking_id = $rowBookings['booking_id'];
                                                    $fullname = $rowBookings['fullname'];
                                                    $email = $rowBookings['email'];
                                                    $phone_number = $rowBookings['phone_number'];
                                                    $date_check_in = (new DateTime($rowBookings['date_check_in']))->format("F j, Y");
                                                    $date_check_out = (new DateTime($rowBookings['date_check_out']))->format("F j, Y");
                                                    $message = $rowBookings['message'];
                                                    $mode_of_payment = $rowBookings['mode_of_payment'];
                                                    $evidence = $rowBookings['evidence'];
                                                    $booking_status_id = $rowBookings['booking_status_id'];
                                                    $created_at = (new DateTime($rowBookings['created_at']))->format("F j, Y");
                                                    $reference_number = $rowBookings['reference_number'];
                                                    $reason_for_cancellation = $rowBookings['reason_for_cancellation'];

                                                    if ($booking_status_id == 1) {
                                                        $status = "Pending";
                                                        $badge = "class='badge bg-warning'";
                                                        $style = "class='text-warning'";
                                                        $cnfrmBtn = "flex;";
                                                        $reason = "none";
                                                    } else if ($booking_status_id == 2) {
                                                        $status = "Confirmed";
                                                        $badge = "class='badge bg-success'";
                                                        $style = "class='text-success'";
                                                        $cnfrmBtn = "none;";
                                                        $reason = "none";
                                                    } else if ($booking_status_id == 3) {
                                                        $status = "Decline";
                                                        $badge = "class='badge bg-danger'";
                                                        $style = "class='text-danger'";
                                                        $cnfrmBtn = "none;";
                                                        $reason = "none";
                                                    } else if ($booking_status_id == 4) {
                                                        $status = "Cancelled";
                                                        $badge = "class='badge bg-warning'";
                                                        $style = "class='text-warning'";
                                                        $cnfrmBtn = "flex;";
                                                        $reason = "block";
                                                    }
                                                    echo "
                                                    <tr>
                                                        <td class='text-center'>$fullname</td>
                                                        <td class='text-center'>$created_at</td>
                                                        <td class='text-center'><span $badge>$status</span></td>
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
                                                                                <h6 style="display: <?= $reason ?>;"><span class="text-secondary">Reason: <br /></span><?= $reason_for_cancellation ?></h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer d-flex justify-content-between p-3">
                                                                        <div class="d-flex">
                                                                            <?php
                                                                            $stmtAssign = $conn->prepare("SELECT * FROM tbl_booking_room WHERE booking_id = ?");
                                                                            $stmtAssign->bind_param('i', $booking_id);
                                                                            $stmtAssign->execute();
                                                                            $resultAssign = $stmtAssign->get_result();
                                                                            if ($resultAssign->num_rows > 0) {
                                                                                $assignRmBtn = "flex;";
                                                                            } else {
                                                                                $assignRmBtn = "none;";
                                                                            }
                                                                            ?>
                                                                            <button style="display: <?= $assignRmBtn ?>" onclick="redirectToAssignRoom()" class="btn btn-sm btn-primary px-3 rounded-5" type="button">
                                                                                <i class="bi bi-pin"></i>&nbsp; Assign Room
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            $(document).ready(function() {
                $('#paginateAllReservations').DataTable({
                    "lengthMenu": [10, 25, 50, 100],
                    "pagingType": "full_numbers",
                    "searching": true,
                    "language": {
                        "paginate": {
                            "first": "Begin",
                            "last": "End",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    }
                });
            });

            function redirectToAssignRoom() {
                const bookingId = <?= json_encode($booking_id) ?>;
                const url = `room-assignment.php?booking_id=${bookingId}`;
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