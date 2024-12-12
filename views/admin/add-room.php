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
                <h1>Add Room</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Add Room</li>
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
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['success'], "Room has been saved successfully!"; ?></span>
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
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="../../controller/admin/add-room-check.php" method="post">
                                    <div class="row mt-2 p-3">
                                        <div class="col-12">
                                            <label for="room_number">Room number:</label>
                                            <input type="text" name="room_number" id="room_number" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_category_id">Room category:</label>
                                            <select name="room_category_id" id="room_category_id" class="form-select">
                                                <option selected disabled>-select-</option>
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
                                            <label for="room_capacity">Room capacity:</label>
                                            <input type="number" name="room_capacity" id="room_capacity" class="form-control">
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

        <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/main.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    </body>

    </html>
<?php

} else {
    header('Location: ../../signout.php');
    exit();
}
?>