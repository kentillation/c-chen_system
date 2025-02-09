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
                <h1>Checked-in Guests</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Checked-in Guests</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-2" id="data-table">
                                    <table class="table" id="paginateAllCheckedIn">
                                        <colgroup>
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Check-in Date</th>
                                                <th>Check-out Date</th>
                                                <th>Reservation Date</th>
                                                <th>Charge</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $checkedIn = 1;
                                            $stmt = $conn->prepare('SELECT
                                                    tb.*,
                                                    SUM(trc.room_category_price) AS payment
                                                FROM tbl_bookings tb
                                                INNER JOIN tbl_booking_room tbr ON tb.booking_id = tbr.booking_id
                                                INNER JOIN tbl_room_category trc ON tbr.room_category_id = trc.room_category_id
                                                WHERE tb.checking_status_id = ?
                                                GROUP BY tb.reference_number
                                                ORDER BY tb.booking_id DESC ');
                                            $stmt->bind_param('i', $checkedIn);
                                            $stmt->execute();
                                            $result_reservation = $stmt->get_result();
                                            while ($reservation_row = $result_reservation->fetch_assoc()) {
                                                $booking_id = $reservation_row['booking_id'];
                                                $fullname = $reservation_row['fullname'];
                                                $date_check_in = (new DateTime($reservation_row['date_check_in']))->format("F j, Y");
                                                $date_check_out = (new DateTime($reservation_row['date_check_out']))->format("F j, Y");
                                                $created_at = (new DateTime($reservation_row['created_at']))->format("F j, Y");
                                                $d_check_in = new DateTime($reservation_row['date_check_in']);
                                                $d_check_out = new DateTime($reservation_row['date_check_out']);
                                                $interval = $d_check_in->diff($d_check_out);
                                                $days = $interval->days;
                                                $payment = $reservation_row['payment'];
                                                $total_payment = number_format(($payment * $days), 2);
                                            ?>
                                                <tr class='small'>
                                                    <td><?= $fullname ?></td>
                                                    <td><?= $date_check_in ?></td>
                                                    <td><?= $date_check_out ?></td>
                                                    <td><?= $created_at ?></td>
                                                    <td>₱ <?= $total_payment ?></td>
                                                    <td>
                                                        <button class='btn btn-primary py-1' data-bs-toggle='modal' data-bs-target='#conFirmCheckOut<?= $booking_id ?>'>
                                                            <i class='bi bi-check'></i><span class='to-hide'>&nbsp; Check-out</span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" tabindex="-1" id="conFirmCheckOut<?= $booking_id ?>">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <form action="../../controller/admin/confirm-check-out.php?booking_id=<?= $booking_id ?>" method="post">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Confirmation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body py-4">
                                                                    <p class="text-center">Are you sure the guest will check out today?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger rounded-2 px-3 py-1" data-bs-dismiss="modal" aria-label="Close">
                                                                        <i class="bi bi-x"></i>&nbsp; Cancel
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary rounded-2 px-3 py-1">
                                                                        <i class="bi bi-check"></i>&nbsp; Yes
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                </tr>
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
        <?php include 'includes/scripts.php' ?>
        <script>
            $(document).ready(function() {
                $('#paginateAllCheckedIn').DataTable({
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