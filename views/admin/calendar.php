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
                    <!-- <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <h5 class="card-title">Schedule Form</h5>
                                    <form action="save_schedule.php" method="post" id="schedule-form">
                                        <input type="hidden" name="id" value="">
                                        <div class="form-group mb-2">
                                            <label for="full_name" class="control-label">Title</label>
                                            <input type="text" class="form-control form-control-sm" name="full_name" id="full_name" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="email" class="control-label">Email</label>
                                            <textarea rows="3" class="form-control form-control-sm" name="email" id="email" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="phone_number" class="control-label">Phone number</label>
                                            <textarea rows="3" class="form-control form-control-sm" name="phone_number" id="phone_number" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="telephone_number" class="control-label">Telephone number</label>
                                            <textarea rows="3" class="form-control form-control-sm" name="telephone_number" id="telephone_number" required></textarea>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="date_check_in" class="control-label">Start</label>
                                            <input type="datetime-local" class="form-control form-control-sm" name="date_check_in" id="date_check_in" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="date_check_out" class="control-label">End</label>
                                            <input type="datetime-local" class="form-control form-control-sm" name="date_check_out" id="date_check_out" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-center">
                                    <button class="btn btn-outline-success" type="submit" form="schedule-form"><i class="bi bi-save"></i>&nbsp; Save</button>
                                    <button class="btn btn-outline-danger" type="reset" form="schedule-form"><i class="bi bi-eraser"></i>&nbsp; Clear</button>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
                                        <dt class="text-muted">Full name</dt>
                                        <dd id="full_name"></dd>

                                        <dt class="text-muted">Email</dt>
                                        <dd id="email"></dd>

                                        <dt class="text-muted">Phone number</dt>
                                        <dd id="phone_number"></dd>

                                        <dt class="text-muted">Telephone number</dt>
                                        <dd id="telephone_number"></dd>

                                        <dt class="text-muted">Start</dt>
                                        <dd id="date_check_in"></dd>

                                        <dt class="text-muted">End</dt>
                                        <dd id="date_check_out"></dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="../../email-reminder">
                                    <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submitRemind' type='button' onclick='submitRemindFn()'>
                                        <span id='remind'>Remind everyone now</span>
                                        <div class='d-flex justify-content-center' style='padding: 4px;'>
                                            <span class='d-flex align-items-center justify-content-center'>
                                                <span id="remind_text" style="display: none;" class='text-dark'>Reminding...</span>
                                                <div class='spinner-border spinner-border-sm' id='loading_remind' style="display: none;" role='status'></div>
                                            </span>
                                        </div>
                                    </button>
                                </a>
                                <div class="text-end">
                                    <button type="button" class="btn btn-outline-success" id="edit" data-id="">
                                        <i class="bi bi-pencil-square"></i>&nbsp; Edit
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-danger" id="delete" data-id="">
                                        <i class="bi bi-trash"></i>&nbsp; Delete
                                    </button> -->
                                    <button class='btn btn-outline-danger' id='submitDelete' type='button' data-id="" onclick='submitDeleteFn()'>
                                        <span id='delete'><i class="bi bi-trash"></i>&nbsp; Delete</span>
                                        <div class='d-flex justify-content-center'>
                                            <span class='d-flex align-items-center justify-content-center'>
                                                <div class='spinner-border spinner-border-sm' id='loading_delete' style="margin: 4px;display: none;" role='status'></div>
                                            </span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="delete-confirm-modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete this schedule?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $schedules = $conn->query("SELECT * FROM tbl_bookings");
                $sched_res = [];
                foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
                    $row['date_check_in'] = date("F d, Y h:i A", strtotime($row['date_check_in']));
                    $row['date_check_out'] = date("F d, Y h:i A", strtotime($row['date_check_out']));
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

        <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/main.js"></script>
        <script src="../../js/script.js"></script>
        <script>
            var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
            var currentDate = new Date();
            document.getElementById("date_check_in").min = currentDate.toISOString().slice(0, -8);
            document.getElementById("date_check_out").min = currentDate.toISOString().slice(0, -8);
        </script>

        <script>
            let submitRemind = document.getElementById("submitRemind");
            let success_alert = document.getElementById("success-alert-container");

            function submitRemindFn() {
                document.getElementById('remind').style.display = "none";
                document.getElementById('loading_remind').style.display = "flex";
                document.getElementById('loading_remind').style.alignItems = "center";
                document.getElementById('loading_remind').style.justifyContent = "center";
                document.getElementById('loading_remind').style.cursor = "not-allowed";
                document.getElementById('remind_text').style.display = "flex";
                document.getElementById('remind_text').style.cursor = "not-allowed";
                submitRemind.classList.remove("btn-primary");
                submitRemind.classList.add("bg-secondary");
                submitRemind.classList.add("btn");
            }

            function submitDeleteFn() {
                document.getElementById('delete').style.display = "none";
                document.getElementById('loading_delete').style.display = "flex";
                document.getElementById('loading_delete').style.alignItems = "center";
                document.getElementById('loading_delete').style.justifyContent = "center";
                document.getElementById('loading_delete').style.cursor = "not-allowed";
                submitRemind.classList.remove("btn-outline-danger");
                submitRemind.classList.add("bg-secondary");
                submitRemind.classList.add("btn");
            }

            success_alert.style.bottom = "10px";
            success_alert.style.transition = "0.5s all ease";
            setTimeout(function() {
                success_alert.style.bottom = "-70px";
                success_alert.style.transition = "0.5s all ease";
            }, 7000);
        </script>

    </body>

    </html>
<?php

} else {
    header('Location: ../../');
    exit();
}
?>