<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $room_number_id = $_GET['room_number_id'];
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
                <h1>Room Details</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Room Details</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <a href="rooms.php">
                    <i class="bi bi-arrow-left"></i>&nbsp; Back
                </a>
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        if (isset($_GET['updated'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['updated'], "Room has been updated successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['unknown'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['unknown'], "An unknown error occured. Please try again!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "Room already existed. Please try again!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        $stmt = $conn->prepare("SELECT tbl_room_number.*,
                        tbl_room_category.room_category_name,
                        tbl_room_category.room_category_price,
                        tbl_room_category.room_capacity,
                        tbl_availability.availability
                        FROM tbl_room_number
                        INNER JOIN tbl_room_category ON tbl_room_number.room_category_id = tbl_room_category.room_category_id
                        INNER JOIN tbl_availability ON tbl_room_number.room_availability_id = tbl_availability.availability_id
                        WHERE tbl_room_number.room_number_id = ?
                        ORDER BY tbl_room_number.room_number");
                        $stmt->bind_param('i', $room_number_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $room_number = $row['room_number'];
                        $room_category_id = $row['room_category_id'];
                        $room_category_name = $row['room_category_name'];
                        $room_availability_id = $row['room_availability_id'];
                        $availability = $row['availability'];
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="../../controller/admin/update-room.php?room_number_id=<?= $room_number_id ?>" method="post">
                                    <div class="row mt-2 p-3">
                                        <div class="col-12">
                                            <label for="room_number">Room number:</label>
                                            <input type="text" name="room_number" value="<?= $room_number ?>" id="room_number" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_category_id">Room category:</label>
                                            <select name="room_category_id" id="room_category_id" class="form-select">
                                                <option value="<?= $room_category_id ?>"><?= $room_category_name ?></option>
                                                <?php
                                                $stmtCategory = $conn->prepare("SELECT * FROM tbl_room_category");
                                                $stmtCategory->execute();
                                                $resultCategory = $stmtCategory->get_result();
                                                while ($rowCategory = $resultCategory->fetch_assoc()) {
                                                    $roomCategoryId = $rowCategory['room_category_id'];
                                                    $roomCategoryName = $rowCategory['room_category_name'];
                                                    echo "
                                                <option value='$roomCategoryId'>$roomCategoryName</option>
                                                ";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_availability_id">Availability:</label>
                                            <select name="room_availability_id" id="room_availability_id" class="form-select">
                                                <option value="<?= $room_availability_id ?>"><?= $availability ?></option>
                                                <?php
                                                $stmtAvailability = $conn->prepare("SELECT * FROM tbl_availability");
                                                $stmtAvailability->execute();
                                                $resultAvailability = $stmtAvailability->get_result();
                                                while ($rowAvailability = $resultAvailability->fetch_assoc()) {
                                                    $roomAvailabilityId = $rowAvailability['availability_id'];
                                                    $roomAvailability = $rowAvailability['availability'];
                                                    echo "
                                                <option value='$roomAvailabilityId'>$roomAvailability</option>
                                                ";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <button class="btn btn-primary px-5 rounded-5" type="submit">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <?php include 'includes/footer.php' ?>
        <?php include 'includes/scripts.php' ?>
    </body>

    </html>
<?php

} else {
    header('Location: ../../signout.php');
    exit();
}
?>