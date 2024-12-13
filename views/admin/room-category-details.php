<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $room_category_id = $_GET['room_category_id'];
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
                <h1>Room Category Details</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Room Category Details</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <a href="categories.php">
                    <i class="bi bi-arrow-left"></i>&nbsp; Back
                </a>
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        if (isset($_GET['updated'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['updated'], "Room category has been updated successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "Room category name already exist. Please try again!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['upload_error'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['upload_error'], "An unknown error occured."; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        $stmt = $conn->prepare("SELECT * FROM tbl_room_category WHERE room_category_id = ?");
                        $stmt->bind_param('i', $room_category_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        // $room_category_id = $row['room_category_id'];
                        $room_category_name = $row['room_category_name'];
                        $room_category_price = $row['room_category_price'];
                        $room_capacity = $row['room_capacity'];
                        $room_details = $row['room_details'];
                        $img_url = $row['img_url'];
                        $c_availability_id = $row['availability_id'];
                        if ($c_availability_id == 1) {
                            $c_availability = "Available";
                        }
                        if ($c_availability_id == 2) {
                            $c_availability = "Unavailable";
                        }
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="../../controller/admin/update-room-category.php?room_category_id=<?= $room_category_id ?>" enctype="multipart/form-data" method="post">
                                    <div class="row mt-2 p-3">
                                        <div class="col-12 mt-3">
                                            <label for="room_category_name">Category name: </label>
                                            <input type="text" name="room_category_name" value="<?= $room_category_name ?>" id="room_category_name" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_category_price">Category price:</label>
                                            <input type="text" name="room_category_price" value="<?= $room_category_price ?>" id="room_category_price" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_capacity">Category capacity:</label>
                                            <input type="text" name="room_capacity" value="<?= $room_capacity ?>" id="room_capacity" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="room_details">Category details:</label>
                                            <textarea name="room_details" cols="30" row="10" id="room_details" class="form-control"><?= $room_details ?></textarea>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <img src="../../rooms/<?= $img_url ?>" width="150" height="150" alt="">
                                            <input type="file" name="img_url" value="<?= $img_url ?>" id="img_url" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="availability_id">Availability:</label>
                                            <select name="availability_id" id="availability_id" class="form-select">
                                                <option value="<?= $c_availability_id ?>"><?= $c_availability ?></option>
                                                <?php
                                                $stmtAvailability = $conn->prepare("SELECT * FROM tbl_availability");
                                                $stmtAvailability->execute();
                                                $resultAvailability = $stmtAvailability->get_result();
                                                while ($rowAvailability = $resultAvailability->fetch_assoc()) {
                                                    $availabilityId = $rowAvailability['availability_id'];
                                                    $availability = $rowAvailability['availability'];
                                                    echo "
                                                <option value='$availabilityId'>$availability</option>
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