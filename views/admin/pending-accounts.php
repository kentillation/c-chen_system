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
                <h1>Pending Accounts</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active">Pending Accounts</li>
                    </ol>
                </nav>
            </div>

            <section class="section dashboard mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <col width="5%">
                                            <col width="20%">
                                            <col width="20%">
                                            <col width="25%">
                                            <col width="10%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th>Date Request</th>
                                                    <th>Activation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pending = 1;
                                                $stmt = $conn->prepare(' SELECT * FROM tbl_student WHERE account_status = ? ORDER BY student_id ASC');
                                                $stmt->bind_param('i', $pending);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $num = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $num++;
                                                    $student_id = $row['student_id'];
                                                    $created_at = $row['created_at'];
                                                    $user_name = $row['user_name'];
                                                    $email = $row['email'];
                                                    echo "
                                                            <tr>
                                                                <td>$num</td>
                                                                <td>$user_name</td>
                                                                <td>$email</td>
                                                                <td>$created_at</td>
                                                                <td>
                                                                    <button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#activateModal$student_id'>
                                                                        <i class='bi bi-broadcast'></i>&nbsp Activate
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='activateModal$student_id'>
                                                                <div class='modal-dialog modal-dialog-centered'>
                                                                    <div class='modal-content'>
                                                                        <form action='../../controller/admin/activate-account?student_id=$student_id' method='post'>
                                                                            <div class='modal-header'>
                                                                                <h5 class='modal-title'>Account Activation</h5>
                                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                                            </div>
                                                                            <div class='modal-body'>
                                                                                <p class='text-center py-3'>Are you sure you want to activate?</p>
                                                                            </div>
                                                                            <div class='modal-footer'>
                                                                                <div class='text-end'>
                                                                                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal' aria-label='Close'>
                                                                                        <i class='bi bi-x-circle'></i>&nbsp; Not now
                                                                                    </button>
                                                                                    <button type='submit' class='btn btn-primary' id='submit' onclick='submitFn()'>
                                                                                        <span id='yes'><i class='bi bi-check-circle'></i>&nbsp; Yes, I am</span>
                                                                                        <div style='cursor: not-allowed;'>
                                                                                            <div class='spinner-border spinner-border-sm' id='loading' style='padding: 8px;' role='status'></div>
                                                                                        </div>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if ($result->num_rows < 1) {
                                            echo '
                                                    <p class="text-center text-secondary">
                                                        <i class="bi bi-envelope-open"></i>&nbsp; You have an empty record.
                                                    </p>
                                                ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <div>
            <?php
            if (isset($_GET['unknown'])) {
            ?>
                <div id="danger-alert-container">
                    <div id="danger-alert">
                        <span class="mx-2">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <?php echo $_GET['unknown'], "Unknown error occured"; ?>
                        </span>
                    </div>
                </div>
            <?php
            }
            if (isset($_GET['success'])) {
            ?>
                <div id="success-alert-container">
                    <div id="success-alert">
                        <span class="mx-2">
                            <i class="bi bi-check-circle me-2"></i>
                            <?php echo $_GET['success'], "Account activated successfully."; ?>
                        </span>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>

        <?php include 'includes/footer.php' ?>

        <script>
            let danger_alert = document.getElementById("danger-alert-container");
            danger_alert.style.bottom = "10px";
            danger_alert.style.transition = "0.5s all ease";
            setTimeout(function() {
                danger_alert.style.bottom = "-70px";
                danger_alert.style.transition = "0.5s all ease";
            }, 7000);
        </script>
        <script>
            let success_alert = document.getElementById("success-alert-container");
            success_alert.style.bottom = "10px";
            success_alert.style.transition = "0.5s all ease";
            setTimeout(function() {
                success_alert.style.bottom = "-70px";
                success_alert.style.transition = "0.5s all ease";
            }, 7000);
        </script>

        <script>
            let user_name = document.getElementById("user_name");
            let password = document.getElementById("password");
            let submit = document.getElementById("submit");
            let alert = document.getElementById("danger-alert-container");

            function submitFn() {
                document.getElementById('yes').style.display = "none";
                document.getElementById('loading').style.display = "flex";
                document.getElementById('loading').style.alignItems = "center";
                document.getElementById('loading').style.justifyContent = "center";
                submit.classList.remove("btn-primary");
                submit.classList.add("bg-secondary");
                submit.classList.add("btn");
                submit.attributes.add("disabled");
            }
        </script>

        <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/main.js"></script>

    </body>

    </html>
<?php

} else {
    header('Location: ../../signout');
    exit();
}
?>