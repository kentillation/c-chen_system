<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_SESSION['id'])) {
?>

    <head>
        <?php include 'includes/head.php' ?>
    </head>

    <body>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <img src="../../assets/img/logo.jpg" alt="Logo" width="90">
            <p class="text-center">
                <span><?php include '../../system-title.php' ?></span><br />
                <span>Brgy. Old Sagay, Sagay City 6122, Philippines</span><br />
                <span class="fw-bold">All Bookings</span>
            </p>
            <p>
                <?php
                date_default_timezone_set('Asia/Manila');
                echo date("F j, Y");
                ?>
            </p>
        </div>
        <div class="col-lg-8 mt-5">
            <div class="border rounded p-3">
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
                                                        <td class='text-center'>$date_check_in</td>
                                                        <td class='text-center'>$date_check_out</td>
                                                        <td class='text-center'>$created_at</td>
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
        <script type="text/javascript">
            function PrintPage() {
                window.print();
            }
            window.addEventListener('DOMContentLoaded', (event) => {
                PrintPage()
                setTimeout(function() {
                    window.close()
                }, 900)
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: logout.php");
}
