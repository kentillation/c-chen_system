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
                <h1>Calendar</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Main</li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container mt-4" id="page-container">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" id="event-details-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Schedule Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <dl>
                                        <dt class="text-muted">Fullname</dt>
                                        <dd id="fullname" class="fw-bold fs-4"></dd>
                                        <!-- <dt class="text-muted">Description</dt>
                                        <dd id="description" class=""></dd> -->
                                        <dt class="text-muted">Check-in</dt>
                                        <dd id="start" class=""></dd>
                                        <dt class="text-muted">Check-out</dt>
                                        <dd id="end" class=""></dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $schedules = $conn->query("SELECT * FROM tbl_schedule");
                $sched_res = [];
                foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                    $row['sdate'] = date("F d, Y", strtotime($row['start_datetime']));
                    $row['edate'] = date("F d, Y", strtotime($row['end_datetime']));
                    $sched_res[$row['id']] = $row;
                }
                ?>
                <?php
                if (isset($conn)) $conn->close();
                ?>
            </section>

        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <?php include 'includes/footer.php' ?>

        <script src="../../assets/js/main.js"></script>
        <script src="../../js/script.js"></script>
        <script src="../../js/jquery-3.6.0.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
        <script src="../../fullcalendar/lib/main.min.js"></script>
        <script>
            var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
            var currentDate = new Date();
        </script>
    </body>

    </html>
<?php

} else {
    header('Location: ../../signout.php');
    exit();
}
?>