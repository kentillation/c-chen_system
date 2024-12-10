<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
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
                                    <div class="ms-3 card-icon rounded-circle d-flex">
                                        <i class="bi bi-inboxes fs-3 mb-2"></i>
                                    </div>
                                    <div class="ps-3">
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
                                    <div class="ms-3 card-icon rounded-circle d-flex">
                                        <i class="bi bi-inboxes-fill fs-3 mb-2"></i>
                                    </div>
                                    <div class="ps-3">
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
                                <div class="table-responsive mt-2" id="data-table">
                                    <table class="table" id="paginateAllReservations">
                                        <colgroup>
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="20%">
                                        </colgroup>
                                        <thead class="bg-secondary-light">
                                            <tr>
                                                <th>Customer name</th>
                                                <th>Booking Date</th>
                                                <th>Charge</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare('
                                                SELECT
                                                    tb.booking_id,
                                                    tb.fullname,
                                                    tb.created_at,
                                                    SUM(trc.room_category_price) AS total_charge,
                                                    tb.booking_status_id
                                                FROM tbl_bookings tb
                                                INNER JOIN tbl_booking_room tbr ON tb.booking_id = tbr.booking_id
                                                INNER JOIN tbl_room_category trc ON tbr.room_category_id = trc.room_category_id
                                                GROUP BY tb.booking_id, tb.fullname, tb.created_at, tb.booking_status_id
                                                ORDER BY tb.booking_id ASC
                                            ');
                                            $stmt->execute();
                                            $result_reservation = $stmt->get_result();
                                            while ($reservation_row = $result_reservation->fetch_assoc()) {
                                                $booking_id = $reservation_row['booking_id'];
                                                $fullname = $reservation_row['fullname'];
                                                $created_at = (new DateTime($reservation_row['created_at']))->format("F j, Y");
                                                $total_charge = "₱ " . number_format($reservation_row['total_charge']);
                                                $booking_status = $reservation_row['booking_status_id'];
                                                if ($booking_status == 1) {
                                                    $status = "Pending";
                                                    $badge = "class='badge bg-warning'";
                                                } elseif ($booking_status == 2) {
                                                    $status = "Confirmed";
                                                    $badge = "class='badge bg-success'";
                                                } elseif ($booking_status == 3) {
                                                    $status = "Declined";
                                                    $badge = "class='badge bg-danger'";
                                                } elseif ($booking_status == 4) {
                                                    $status = "Cancelled";
                                                    $badge = "class='badge bg-warning'";
                                                }
                                                echo "
                                                <tr class='small'>
                                                    <td>$fullname</td>
                                                    <td>$created_at</td>
                                                    <td>$total_charge</td>
                                                    <td><span $badge>$status</span></td>
                                                    <td>
                                                        <a href='booking-details?booking_id=$booking_id'>
                                                            <button class='btn btn-sm btn-primary rounded-5 py-1' data-bs-toggle='modal' data-bs-target='#infoModal$booking_id'>
                                                                <i class='bi bi-eye'></i><span class='to-hide'>&nbsp; View</span>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                ";
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