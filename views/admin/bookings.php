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
                                            $check = 3;
                                            $stmtBookings = $conn->prepare(' SELECT
                                            t_b.*,
                                            t_mop.mode_of_payment
                                            FROM tbl_bookings t_b
                                            INNER JOIN tbl_mode_of_payment t_mop ON t_b.mode_of_payment_id = t_mop.mode_of_payment_id
                                            WHERE t_b.checking_status_id = ?
                                            ORDER BY t_b.created_at ASC');
                                            $stmtBookings->bind_param('i', $check);
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
                                                        $cnfrmBtn = "block;";
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
                                                        $cnfrmBtn = "block;";
                                                        $reason = "block";
                                                    }
                                                    echo "
                                                    <tr>
                                                        <td class='text-center'>$fullname</td>
                                                        <td class='text-center'>$created_at</td>
                                                        <td class='text-center'><span $badge>$status</span></td>
                                                        <td class='text-center'>
                                                            <a href='booking-details.php?booking_id=$booking_id'>
                                                                <button class='btn btn-sm btn-primary rounded-5' type='button'>
                                                                    <i class='bi bi-eye'></i>&nbsp; <span class='to-hide'>View</span>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    ";
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
        <?php include 'includes/scripts.php' ?>
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
        </script>
    </body>

    </html>
<?php

} else {
    header('Location: ../../signout.php');
    exit();
}
?>