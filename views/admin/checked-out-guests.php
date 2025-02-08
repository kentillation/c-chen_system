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
                <h1>Checked-out Guests</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Checked-out Guests</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-2" id="data-table">
                                    <table class="table" id="paginateCheckedOut">
                                        <colgroup>
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                        </colgroup>
                                        <thead class="bg-secondary-light">
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Check-out Date</th>
                                                <th>Reservation Date</th>
                                                <th>Charge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $checkedOut = 2;
                                            $stmt = $conn->prepare('SELECT
                                                    tb.*,
                                                    tcg.created_at AS check_out,
                                                    tcg.checking_status_id AS checking_status,
                                                    SUM(trc.room_category_price) AS payment
                                                FROM tbl_bookings tb
                                                INNER JOIN tbl_booking_room tbr ON tb.booking_id = tbr.booking_id
                                                INNER JOIN tbl_room_category trc ON tbr.room_category_id = trc.room_category_id
                                                INNER JOIN tbl_checking_guest tcg ON tb.booking_id = tcg.booking_id
                                                WHERE tb.checking_status_id = ?
                                                GROUP BY tb.reference_number
                                                ORDER BY tb.booking_id DESC ');
                                            $stmt->bind_param('i', $checkedOut);
                                            $stmt->execute();
                                            $result_reservation = $stmt->get_result();
                                            while ($reservation_row = $result_reservation->fetch_assoc()) {
                                                $booking_id = $reservation_row['booking_id'];
                                                $fullname = $reservation_row['fullname'];
                                                $created_at = (new DateTime($reservation_row['created_at']))->format("F j, Y H:i:s a");
                                                $check_out = (new DateTime($reservation_row['check_out']))->format("F j, Y H:i:s a");
                                                $d_check_in = new DateTime($reservation_row['date_check_in']);
                                                $d_check_out = new DateTime($reservation_row['date_check_out']);
                                                $interval = $d_check_in->diff($d_check_out);
                                                $days = $interval->days;
                                                $payment = $reservation_row['payment'];
                                                $total_payment = number_format(($payment * $days), 2);
                                            ?>
                                                <tr class='small'>
                                                    <td><?= $fullname ?></td>
                                                    <td><?= $check_out ?></td>
                                                    <td><?= $created_at ?></td>
                                                    <td>₱ <?= $total_payment ?></td>
                                                </tr>
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
                $('#paginateCheckedOut').DataTable({
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