<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
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
                <h1>Change Password</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </nav>
            </div>
            <a href="profile">
                <i class="bi bi-arrow-left mt-5"></i>&nbsp; Back
            </a>
            <section class="section d-flex flex-column align-items-center justify-content-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center flex-column">
                                <div class="mt-5 text-center">
                                    <form action="../../controller/admin/submit-verification-code.php" method="post">
                                        <h5 class="card-title">Verification code has been sent to your email.</h5>
                                        <input type="text" name="verification_code" class="form-control mt-3 mb-2" placeholder="Type your verification code here...">
                                        <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submitVerificationCode' type='submit' onclick='submitFn()'>
                                            <span id='submitId'>Submit</span>
                                            <div class='d-flex justify-content-center' style='padding: 4px;'>
                                                <div class='spinner-border spinner-border-sm' id='loading' style="display: none;" role='status'></div>
                                            </div>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </div>
        </main>

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <?php
        if (isset($_GET['verification_error'])) {
        ?>
            <div id="danger-alert-container" style="z-index: 9999;">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $_GET['verification_error'], "Invalid verification code."; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        if (isset($_GET['unknown'])) {
        ?>
            <div id="danger-alert-container" style="z-index: 9999;">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $_GET['unknown'], "Unknown error occured."; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        ?>
        <?php include 'includes/footer.php' ?>

        <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/main.js"></script>
        <script>
            let submitVerificationCode = document.getElementById("submitVerificationCode");

            function submitFn() {
                document.getElementById('submitId').style.display = "none";
                document.getElementById('loading').style.display = "flex";
                document.getElementById('loading').style.alignItems = "center";
                document.getElementById('loading').style.justifyContent = "center";
                document.getElementById('loading').style.cursor = "not-allowed";
                submitVerificationCode.classList.remove("btn-primary");
                submitVerificationCode.classList.add("bg-secondary");
                submitVerificationCode.classList.add("btn");
                submitVerificationCode.style.cursor = "not-allowed";

            }
        </script>
        <script>
            let danger_alert = document.getElementById("danger-alert-container");
            danger_alert.style.bottom = "10px";
            danger_alert.style.transition = "0.5s all ease";
            setTimeout(function() {
                danger_alert.style.bottom = "-70px";
                danger_alert.style.transition = "0.5s all ease";
            }, 7000);
        </script>

    </body>

    </html>

<?php
} else {
    header('Location: ../../signout');
    exit();
}
?>