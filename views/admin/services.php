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
                <h1>Services</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Services</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive mt-4" id="data-table">
                                    <table class="table" id="paginateAllServices">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <col width="20%">
                                        <thead>
                                            <tr>
                                                <th>Service name</th>
                                                <th>Service price</th>
                                                <th>Service Duration</th>
                                                <th>Availability</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $stmt = $conn->prepare("SELECT * FROM tbl_services");
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($row = $result->fetch_assoc()) {
                                                $service_id = $row['service_id'];
                                                $service_name = $row['service_name'];
                                                $service_price = $row['service_price'];
                                                $service_duration = $row['service_duration'];
                                                $service_availability_id = $row['service_availability_id'];
                                                if ($service_availability_id == 1) {
                                                    $availability = "Available";
                                                    $style = "color: green;";
                                                    $toUnavail = "display: flex;";
                                                    $toAvail = "display: none";
                                                }
                                                if ($service_availability_id == 2) {
                                                    $availability = "Unavailable";
                                                    $style = "color: red;";
                                                    $toUnavail = "display: none;";
                                                    $toAvail = "display: flex";
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $service_name ?></td>
                                                    <td><?= $service_price ?></td>
                                                    <td><?= $service_duration ?></td>
                                                    <td style="<?= $style ?>"><?= $availability ?></td>
                                                    <td>
                                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#toUnavailModal<?= $service_id ?>" style="<?= $toUnavail ?>">
                                                            <i class=" bi bi-ui-checks"></i>&nbsp; Set
                                                        </button>
                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#toAvailModal<?= $service_id ?>" style="<?= $toAvail ?>">
                                                            <i class="bi bi-ui-checks"></i>&nbsp; Set
                                                        </button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="toUnavailModal<?= $service_id ?>" aria-hidden="true" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmation</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-center">Are you sure you want to set the service to Unavailable?</p>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between p-3">
                                                                <a href="../../controller/admin/to-unavail.php?service_id=<?= $service_id ?>">
                                                                    <button class="btn btn-sm btn-success px-3 rounded-5 ms-1" type="submit">
                                                                        <i class="bi bi-check"></i>&nbsp; Confirm
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="toAvailModal<?= $service_id ?>" aria-hidden="true" tabindex="-1">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmation</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-center">Are you sure you want to set the service to Available?</p>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between p-3">
                                                                <a href="../../controller/admin/to-avail.php?service_id=<?= $service_id ?>">
                                                                    <button class="btn btn-sm btn-success px-3 rounded-5 ms-1" type="submit">
                                                                        <i class="bi bi-check"></i>&nbsp; Confirm
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
        <script>
            $(document).ready(function() {
                $('#paginateAllServices').DataTable({
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