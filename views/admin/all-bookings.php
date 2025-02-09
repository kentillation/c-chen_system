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
                <h1>All Bookings</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">All Bookings</li>
                    </ol>
                </nav>
                <a href="print-bookings.php" target="_blank">
                    <button class="btn btn-primary"><i class="bi bi-printer"></i>&nbsp; Print</button>
                </a>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-4" id="data-table">
                                    <table class="table" id="paginateAllReservations">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <thead>
                                            <tr>
                                                <th>Booking #</th>
                                                <th>Booking date</th>
                                                <th>Check-in date</th>
                                                <th>Check-out date</th>
                                                <th>Operator</th>
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
                                                    $reference_number = $rowBookings['reference_number'];
                                                    $date_check_in = (new DateTime($rowBookings['date_check_in']))->format("F j, Y");
                                                    $date_check_out = (new DateTime($rowBookings['date_check_out']))->format("F j, Y");
                                                    $created_at = (new DateTime($rowBookings['created_at']))->format("F j, Y");
                                                    echo "
                                                    <tr>
                                                        <td class='text-center'>$reference_number</td>
                                                        <td class='text-center'>$created_at</td>
                                                        <td class='text-center'>$date_check_in</td>
                                                        <td class='text-center'>$date_check_out</td>
                                                        <td class='text-center'>ADMINISTRATOR</td>
                                                    </tr>
                                                    ";
                                            ?>
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