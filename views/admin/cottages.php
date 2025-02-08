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
                <h1>Cottages</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Cottages</li>
                    </ol>
                </nav>
                <a href="add-cottage.php">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-plus-lg"></i>&nbsp; Add Cottage
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
                                <span><?php echo $_GET['success'], "New cottage has been saved successfully!"; ?></span>
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
                                    <table class="table" id="paginateAllCottages">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <col width="15%">
                                        <thead>
                                            <tr>
                                                <th>Cottage Name</th>
                                                <th>Cottage Price</th>
                                                <th>Cottage Capacity</th>
                                                <th>Cottage Image</th>
                                                <th>Availability</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare("SELECT *,
                                            tbl_availability.availability
                                            FROM tbl_cottages
                                            INNER JOIN tbl_availability ON tbl_cottages.cottage_availability_id = tbl_availability.availability_id");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $cottage_id = $row['cottage_id'];
                                                $cottage_name = $row['cottage_name'];
                                                $cottage_price = $row['cottage_price'];
                                                $cottage_capacity = $row['cottage_capacity'];
                                                $cottage_image = $row['cottage_image'];
                                                $cottage_availability_id = $row['cottage_availability_id'];
                                                $availability = $row['availability'];
                                                if ($cottage_availability_id == 1) {
                                                    $style = "color: green;";
                                                }
                                                if ($cottage_availability_id == 2) {
                                                    $style = "color: red;";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $cottage_name ?></td>
                                                    <td><?= $cottage_price ?></td>
                                                    <td><?= $cottage_capacity ?> pax</td>
                                                    <td>
                                                        <img src="../../cottages/<?= $cottage_image ?>" width="200" alt="Cottage Image">
                                                    </td>
                                                    <td style="<?= $style ?>"><?= $availability ?></td>
                                                    <td>
                                                        <a href="cottage-details.php?cottage_id=<?= $cottage_id ?>">
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
                $('#paginateAllCottages').DataTable({
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