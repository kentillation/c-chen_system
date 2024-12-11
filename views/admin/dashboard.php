<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    date_default_timezone_set('Asia/Manila');
    $bought_day =  date("Y-m-d");
    $bought_month = date("Y-m");
    $bought_year = date("Y");
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
                <h1>Dasboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Dasboard</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="card info-card small-card">
                            <div class="filter">
                                <a class="icon me-2 p-0" href="#" data-bs-toggle="dropdown"><i class="bi bi-filter fs-4"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-dark">
                                    <li class="dropdown-header text-start">
                                        <h6>DATE Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item sales" style="color: #af8d02 !important;" href="#" id="sales_today">Today</a></li>
                                    <li><a class="dropdown-item sales" style="color: #af8d02 !important;" href="#" id="sales_thismonth">This Month</a></li>
                                    <li><a class="dropdown-item sales" style="color: #af8d02 !important;" href="#" id="sales_thisyear">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="card-title">Total Sales</h5>
                                    <span id="sales-text" class="me-4" style="font-size: 13px;"></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center ps-3">
                                    <h2 class='py-1'><span id="sales_revenue"></span></h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="card info-card small-card">
                            <div class="filter">
                                <a class="icon me-2 p-0" href="#" data-bs-toggle="dropdown"><i class="bi bi-filter fs-4"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-dark">
                                    <li class="dropdown-header text-start">
                                        <h6>DATE Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item res_history" style="color: #af8d02 !important;" href="#" id="res_history_today">Today</a></li>
                                    <li><a class="dropdown-item res_history" style="color: #af8d02 !important;" href="#" id="res_history_thismonth">This Month</a></li>
                                    <li><a class="dropdown-item res_history" style="color: #af8d02 !important;" href="#" id="res_history_thisyear">This Year</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5 class="card-title">Booking History</h5>
                                    <span id="history-text" class="me-3" style="font-size: 13px;"></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mt-3">
                                    <h4 class='me-3'><span id="total_history"></span></h4>
                                    <a href='bookings'><button class='btn btn-sm btn-primary rounded-5 px-3 py-1'>View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="card info-card small-card">
                            <div class="card-body">
                                <h5 class="card-title">Available Rooms</h5>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="">
                                        <?php
                                        date_default_timezone_set('Asia/Manila');
                                        $current_date = date('Y-m-d');
                                        $avlblRm = 1;
                                        $query = " SELECT
                                            COUNT(DISTINCT trn.room_number) AS available_rooms
                                            FROM tbl_room_number trn
                                            WHERE trn.room_number NOT IN (
                                                SELECT trr.room_number
                                                FROM tbl_booking_room trr
                                                INNER JOIN tbl_bookings tb
                                                ON trr.booking_id = tb.booking_id
                                                WHERE trn.room_availability_id = ? AND ? BETWEEN tb.date_check_in AND tb.date_check_out
                                            )
                                        ";
                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param('is', $avlblRm, $current_date);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            if ($row['available_rooms'] > 0) {
                                                $available_rooms = $row['available_rooms'];
                                                echo "<h2 class='py-1'>$available_rooms rooms</h2>";
                                            } else {
                                                echo "<h4 class='fs-5 text-danger'>No available rooms</h4>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-3 col-md-6 col-sm-6">
                        <div class="card info-card small-card">
                            <div class="card-body">
                                <h5 class="card-title">Occupied Rooms</h5>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="">
                                        <?php
                                        $confirmed = 2;
                                        date_default_timezone_set('Asia/Manila');
                                        $current_date_time = date('Y-m-d');
                                        $stmt = $conn->prepare("SELECT COUNT(DISTINCT trr.room_number) AS occupied_rooms
                                        FROM tbl_bookings tb
                                        JOIN tbl_booking_room trr ON tb.booking_id = trr.booking_id
                                        WHERE tb.booking_status_id = ? 
                                        AND ? BETWEEN tb.date_check_in AND tb.date_check_out");
                                        $stmt->bind_param('is', $confirmed, $current_date_time);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $row = $result->fetch_assoc();
                                        if ($row['occupied_rooms'] > 0) {
                                            $occupied = $row['occupied_rooms'];
                                            echo "<h2 class='py-1'>$occupied rooms</h2>";
                                        } else {
                                            echo "<h4 class='fs-5 text-primary'>All rooms are available</h4>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card px-2">
                            <div class="card-body">
                                <div class="table-responsive mt-4" id="data-table">
                                    <table class="table" id="paginateAllReservations">
                                        <colgroup>
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                            <col width="25%">
                                        </colgroup>
                                        <thead class="bg-secondary-light">
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Booking Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare(' SELECT
                                                    tb.*,
                                                    SUM(trc.room_category_price) AS total_charge,
                                                    tb.booking_status_id,
                                                    tmop.mode_of_payment
                                                FROM tbl_bookings tb
                                                INNER JOIN tbl_booking_room tbr ON tb.booking_id = tbr.booking_id
                                                INNER JOIN tbl_room_category trc ON tbr.room_category_id = trc.room_category_id
                                                INNER JOIN tbl_mode_of_payment tmop ON tb.mode_of_payment_id = tmop.mode_of_payment_id
                                                GROUP BY tb.booking_id, tb.fullname, tb.created_at, tb.booking_status_id
                                                ORDER BY tb.booking_id ASC
                                            ');
                                            $stmt->execute();
                                            $result_reservation = $stmt->get_result();
                                            if ($result_reservation->num_rows > 0) {
                                                while ($reservation_row = $result_reservation->fetch_assoc()) {
                                                    $booking_id = $reservation_row['booking_id'];
                                                    $fullname = $reservation_row['fullname'];
                                                    $email = $reservation_row['email'];
                                                    $phone_number = $reservation_row['phone_number'];
                                                    $date_check_in = (new DateTime($reservation_row['date_check_in']))->format("F j, Y");
                                                    $date_check_out = (new DateTime($reservation_row['date_check_out']))->format("F j, Y");
                                                    $message = $reservation_row['message'];
                                                    $mode_of_payment = $reservation_row['mode_of_payment'];
                                                    $evidence = $reservation_row['evidence'];
                                                    $created_at = (new DateTime($reservation_row['created_at']))->format("F j, Y");
                                                    $reference_number = $reservation_row['reference_number'];
                                                    $reason_for_cancellation = $reservation_row['reason_for_cancellation'];
                                                    $booking_status = $reservation_row['booking_status_id'];
                                                    if ($booking_status == 1) {
                                                        $status = "Pending";
                                                        $badge = "class='badge bg-warning'";
                                                        $style = "class='text-warning'";
                                                        $cnfrmBtn = "flex;";
                                                        $reason = "none";
                                                    } elseif ($booking_status == 2) {
                                                        $status = "Confirmed";
                                                        $badge = "class='badge bg-success'";
                                                        $style = "class='text-success'";
                                                        $cnfrmBtn = "none;";
                                                        $reason = "none";
                                                    } elseif ($booking_status == 3) {
                                                        $status = "Declined";
                                                        $badge = "class='badge bg-danger'";
                                                        $style = "class='text-danger'";
                                                        $cnfrmBtn = "none;";
                                                        $reason = "none";
                                                    } elseif ($booking_status == 4) {
                                                        $status = "Cancelled";
                                                        $badge = "class='badge bg-warning'";
                                                        $style = "class='text-warning'";
                                                        $cnfrmBtn = "flex;";
                                                        $reason = "block";
                                                    }
                                                    echo "
                                                <tr class='small'>
                                                    <td class='text-center'>$fullname</td>
                                                    <td class='text-center'>$created_at</td>
                                                    <td class='text-center'><span $badge>$status</span></td>
                                                    <td class='text-center'>
                                                        <button class='btn btn-sm btn-primary rounded-5 px-3' data-bs-toggle='modal' data-bs-target='#infoModal$booking_id'>
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
            function redirectToAssignRoom() {
                const bookingId = <?= json_encode($booking_id) ?>;
                const url = `room-assignment.php?booking_id=${bookingId}`;
                window.location.href = url;
            }
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
            $(document).ready(function() {
                $(".sales").click(function() {
                    var filter = $(this).attr("id");
                    $.ajax({
                        url: "filter_sales.php",
                        type: "POST",
                        data: {
                            filter: filter,
                            bought_day: '<?php echo $bought_day; ?>',
                            bought_month: '<?php echo $bought_month; ?>',
                            bought_year: '<?php echo $bought_year; ?>',
                        },
                        success: function(data) {
                            console.log(data);
                            if (filter === "sales_today") {
                                $("#sales_revenue").html("₱ " + (data.today_sales_revenue || 0));
                                $("#sales-text").html("Today");
                            } else if (filter === "sales_thismonth") {
                                $("#sales_revenue").html("₱ " + (data.month_sales_revenue || 0));
                                $("#sales-text").html("This Month");
                            } else if (filter === "sales_thisyear") {
                                $("#sales_revenue").html("₱ " + (data.year_sales_revenue || 0));
                                $("#sales-text").html("This Year");
                            }
                        },
                        error: function() {
                            console.log("Error in AJAX request.");
                        }
                    });
                });
                $("#sales_today").trigger("click");
            });
        </script>
        <script>
            $(document).ready(function() {
                $(".res_history").click(function() {
                    var filter = $(this).attr("id");
                    $.ajax({
                        url: "filter_history.php",
                        type: "POST",
                        data: {
                            filter: filter,
                            bought_day: '<?php echo $bought_day; ?>',
                            bought_month: '<?php echo $bought_month; ?>',
                            bought_year: '<?php echo $bought_year; ?>',
                        },
                        success: function(data) {
                            console.log(data);
                            if (filter === "res_history_today") {
                                $("#total_history").html((data.today_total_history || 0));
                                $("#history-text").html("Today");
                            } else if (filter === "res_history_thismonth") {
                                $("#total_history").html((data.month_total_history || 0));
                                $("#history-text").html("This Month");
                            } else if (filter === "res_history_thisyear") {
                                $("#total_history").html((data.year_total_history || 0));
                                $("#history-text").html("This Year");
                            }
                        },
                        error: function() {
                            console.log("Error in AJAX request.");
                        }
                    });
                });
                $("#res_history_today").trigger("click");
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