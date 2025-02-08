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
                <h1>Add Cottage</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Add Cottage</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <a href="cottages.php">
                    <i class="bi bi-arrow-left"></i>&nbsp; Back
                </a>
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        if (isset($_GET['success'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['success'], "Cottage has been saved successfully!"; ?></span>
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
                                <form action="../../controller/admin/add-cottage-check.php" enctype="multipart/form-data" method="post">
                                    <div class="row mt-2 p-3">
                                        <div class="col-12">
                                            <label for="cottage_name">Cottage name:</label>
                                            <input type="text" name="cottage_name" id="room_number" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_price">Cottage price:</label>
                                            <input type="text" name="cottage_price" id="cottage_price" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_capacity">Cottage capacity:</label>
                                            <input type="text" name="cottage_capacity" id="cottage_capacity" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_image">Cottage capacity:</label>
                                            <input type="file" accept="image/*" name="cottage_image" id="cottage_image" class="form-control">
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