<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $cottage_id = $_GET['cottage_id'];
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
                <h1>Cottage Details</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Cottage Details</li>
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
                        if (isset($_GET['updated'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['updated'], "Cottage has been updated successfully!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "Cottage already exist. Please try again!"; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        if (isset($_GET['existed'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" role="alert">
                                <span><?php echo $_GET['existed'], "An unknown error occured."; ?></span>
                                <a href="#">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </a>
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        $stmt = $conn->prepare("SELECT *,
                        tbl_availability.availability
                        FROM tbl_cottages
                        INNER JOIN tbl_availability ON tbl_cottages.cottage_availability_id = tbl_availability.availability_id
                        WHERE tbl_cottages.cottage_id = ?");
                        $stmt->bind_param('i', $cottage_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $cottage_name = $row['cottage_name'];
                        $cottage_price = $row['cottage_price'];
                        $cottage_capacity = $row['cottage_capacity'];
                        $cottage_availability_id = $row['cottage_availability_id'];
                        $availability = $row['availability'];
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <form action="../../controller/admin/update-cottage.php" method="post">
                                    <div class="row mt-2 p-3">
                                        <input type="hidden" name="cottage_id" value="<?= $cottage_id ?>" id="cottage_id">
                                        <div class="col-12 mt-3">
                                            <label for="cottage_name">Cottage name: </label>
                                            <input type="text" name="cottage_name" value="<?= $cottage_name ?>" id="cottage_name" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_price">Cottage price:</label>
                                            <input type="text" name="cottage_price" value="<?= $cottage_price ?>" id="cottage_price" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_capacity">Cottage capacity:</label>
                                            <input type="text" name="cottage_capacity" value="<?= $cottage_capacity ?>" id="cottage_capacity" class="form-control">
                                        </div>
                                        <div class="col-12 mt-3">
                                            <label for="cottage_availability_id">Availability:</label>
                                            <select name="cottage_availability_id" id="cottage_availability_id" class="form-select">
                                                <option value="<?= $cottage_availability_id ?>"><?= $availability ?></option>
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