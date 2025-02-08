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
                <h1>Rooms</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Rooms</li>
                    </ol>
                </nav>
                <a href="add-room.php">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-plus-lg"></i>&nbsp; Add Room
                    </button>
                </a>

            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['success'], "New room has been saved successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "Room already existed. Please try again!"; ?></span>
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
                                    <table class="table" id="paginateAllRooms">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <thead>
                                            <tr>
                                                <th>Room Number</th>
                                                <th>Room Category</th>
                                                <th>Room Price</th>
                                                <th>Room Capacity</th>
                                                <th>Availability</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare("SELECT tbl_room_number.*,
                                            tbl_room_category.room_category_name,
                                            tbl_room_category.room_category_price,
                                            tbl_room_category.room_capacity
                                            FROM tbl_room_number
                                            INNER JOIN tbl_room_category ON tbl_room_number.room_category_id = tbl_room_category.room_category_id
                                            ORDER BY tbl_room_number.room_number");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $room_number_id = $row['room_number_id'];
                                                $room_number = $row['room_number'];
                                                $room_category_name = $row['room_category_name'];
                                                $room_category_price = $row['room_category_price'];
                                                $room_capacity = $row['room_capacity'];
                                                $room_availability_id = $row['room_availability_id'];
                                                if ($room_availability_id == 1) {
                                                    $room_availability = "Available";
                                                    $style = "color: green;";
                                                }
                                                if ($room_availability_id == 2) {
                                                    $room_availability = "Unavailable";
                                                    $style = "color: red;";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $room_number ?></td>
                                                    <td><?= $room_category_name ?></td>
                                                    <td><?= $room_category_price ?></td>
                                                    <td><?= $room_capacity ?> pax</td>
                                                    <td style="<?= $style ?>"><?= $room_availability ?></td>
                                                    <td>
                                                        <a href="room-details.php?room_number_id=<?= $room_number_id ?>">
                                                            <button class="btn btn-primary rounded-5">
                                                                <i class="bi bi-pencil-square"></i>&nbsp; Edit
                                                            </button>
                                                        </a>
                                                    </td>
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
                $('#paginateAllRooms').DataTable({
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