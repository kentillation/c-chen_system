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
                <h1>Categories</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Categories</li>
                    </ol>
                </nav>
                <a href="add-room-category.php">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-plus-lg"></i>&nbsp; Add Category
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
                                <span><?php echo $_GET['success'], "New category has been saved successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "Room category existed. Please try again!"; ?></span>
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
                                    <table class="table" id="paginateAllCategories">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Category Name</th>
                                                <th>Category Price</th>
                                                <th>Room Capacity</th>
                                                <th>Room Details</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM tbl_room_category");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $room_category_id = $row['room_category_id'];
                                                $room_category_name = $row['room_category_name'];
                                                $room_category_price = $row['room_category_price'];
                                                $room_capacity = $row['room_capacity'];
                                                $room_details = $row['room_details'];
                                                $img_url = $row['img_url'];
                                            ?>
                                                <tr>
                                                    <td>
                                                        <img src="../../rooms/<?= $img_url ?>" width="100" height="100" alt="">
                                                    </td>
                                                    <td><?= $room_category_name ?></td>
                                                    <td><?= $room_category_price ?></td>
                                                    <td><?= $room_capacity ?> pax</td>
                                                    <td><?= $room_details ?></td>
                                                    <td>
                                                        <a href="room-category-details.php?room_category_id=<?= $room_category_id ?>">
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