<?php include './config.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php include './system-title.php' ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link href="assets/img/logo.jpg" rel="icon">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="assets1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets1/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets1/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets1/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets1/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets1/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets1/css/main.css" rel="stylesheet">
</head>
<style>
    .form-check {
        padding-left: 0 !important;
    }

    #services {
        display: grid;
        place-items: center;
    }

    #room_numbers1 input[type="checkbox"],
    #services input[type="checkbox"] {
        transform: scale(2);
        -webkit-transform: scale(2);
        margin-right: 20px;
    }

    #room_numbers1 img {
        margin: 30px;
        border-radius: 8px;
    }

    #room_numbers1 input[type="checkbox"]:checked+label,
    #room_numbers1 input[type="checkbox"]:hover+label {
        cursor: pointer;
        border: 2px solid #2c5f77;
        box-shadow: 0px 0px 20px rgba(1, 80, 126, 0.356);
        border-radius: 8px;
        background: linear-gradient(to right, #008672bd, #0583aaea);
        transition: all ease-in-out .5s;
    }

    #room_numbers1 input[type="checkbox"]:active+label {
        cursor: pointer;
        box-shadow: 0px 0px 20px rgba(1, 80, 126, 0.356);
        background: linear-gradient(to right, #0583aaea, #008672bd);
    }

    #room_numbers1 input[type="checkbox"] {
        display: none;
    }

    #room_numbers1 h3,
    #room_numbers1 h5 {
        font-family: 'Poppins';
    }
</style>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.php" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets1/img/logo.png" alt=""> -->
                <h1 class="sitename"><?php include './system-title.php' ?></h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.php?#hero">Home</a></li>
                    <li><a href="index.php?#about">About</a></li>
                    <li><a href="index.php?#features">Services</a></li>
                    <li><a href="index.php?#team">Team</a></li>
                    <li><a href="index.php?#contact">Contact</a></li>
                    <li class="dropdown"><a href="#"><span>More</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms and Conditions</a></li>
                            <li class="dropdown"><a href="#"><span>Others</span> <i
                                        class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="#">Menu 1</a></li>
                                    <li><a href="#">Menu 2</a></li>
                                    <li><a href="#">Menu 3</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#booking" class="custom-button">Book now!</a>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background">
            <div class="container position-relative">
                <h1>Bookings</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index.php">Home</a></li>
                        <li class="current">Bookings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php
        if (isset($_GET['success'])) {
        ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['success'], "Your booking has been save successfully!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['invalid_email'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['invalid_email'], "Your email is invalid. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['too_large'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['too_large'], "Your file is too large. Please upload 10MB below file!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['schedule_error'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['schedule_error'], "Invalid schedule. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['booking_error'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['booking_error'], "Booking failed. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['wrong_file_type'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['wrong_file_type'], "Your file is not a .png .jpeg or jpg. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['upload_error'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['upload_error'], "Error when uploading. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        if (isset($_GET['missing_data'])) {
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center rounded-0" role="alert">
                <span><?php echo $_GET['missing_data'], "Missing data. Please try again!"; ?></span>
                <a href="#">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </a>
            </div>
        <?php
        }
        ?>

        <section class="contact section">

            <div class="container section-title" data-aos="fade-up">
                <p>Don’t wait – book now and start your journey to relaxation and rejuvenation!</p>
            </div>
            <div class="container" data-aos="fade" data-aos-delay="100">
                <div class="row gy-4 mx-auto">
                    <div class="col-lg-12">
                        <!-- Saving form to database -->
                        <form action="./controller/save-booking.php" method="POST" enctype="multipart/form-data" id="schedule-form" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <input type="hidden" name="id" value="">
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label for="date_check_in"><span class="text-danger me-1">*</span>Starting Date</label>
                                    <input type="date" name="date_check_in" class="form-control" id="date_check_in" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_check_out"><span class="text-danger me-1">*</span>Ending Date</label>
                                    <input type="date" name="date_check_out" class="form-control" id="date_check_out" placeholder="Type here..." required disabled>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div id="room_numbers1">
                                        <div class="row mt-4">
                                            <?php
                                            $stmt = $conn->prepare(' SELECT * FROM tbl_room_category ');
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            while ($rows = $result->fetch_assoc()) {
                                                $room_category_id = $rows['room_category_id'];
                                                $room_category_name = $rows['room_category_name'];
                                                $room_category_price = $rows['room_category_price'];
                                                $room_capacity = $rows['room_capacity'];
                                                $img_url = $rows['img_url'];
                                            ?>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                    <h5><strong><?= $room_category_name ?></strong></h5>
                                                    <div class="d-flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="room_category_id<?= $room_category_id ?>" id="room_category_id<?= $room_category_id ?>" value="<?= $room_category_id ?>" required>
                                                            <label class="form-check-label border-0" for="room_category_id<?= $room_category_id ?>">
                                                                <img src="rooms/<?= $img_url ?>" width="250" height="250" id="room_category_id<?= $room_category_id ?>" alt="">
                                                            </label>
                                                        </div>
                                                        <div class="mt-5 ms-2">
                                                            <h3><?= $room_category_price ?> for 1 night</h3>
                                                            <p><i class="bi bi-people"></i>&nbsp; <?= $room_capacity ?> pax</p>
                                                            <p><i class="bi bi-wifi"></i>&nbsp; Free Wifi</p>
                                                            <p><i class="bi bi-droplet"></i>&nbsp; Free toiletries</p>
                                                            <p><i class="bi bi-snow2"></i>&nbsp; Air-conditioning</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="services" class="my-5">
                                <label for="" class="mb-2"><span class="text-danger me-1">*</span>Services</label>
                                <div class="d-flex">
                                    <?php
                                    // Fetching data from database
                                    $stmt = $conn->prepare(' SELECT * FROM tbl_services ');
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($rows = $result->fetch_assoc()) {
                                        $service_id = $rows['service_id'];
                                        $service_name = $rows['service_name'];
                                    ?>
                                        <div class="form-check">
                                            <label for="service_id<?= $service_id ?>" class="form-check-label me-5"><?= $service_name ?></label>
                                            <input type="checkbox" name="service_id[]" id="service_id<?= $service_id ?>" value="<?= $service_id ?>" class="form-check-input">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div id="available-rooms"></div>
                            </div>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="fullname"><span class="text-danger me-1">*</span>Full name</label>
                                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email"><span class="text-danger me-1">*</span>Email</label>
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number"><span class="text-danger me-1">*</span>Phone number</label>
                                    <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="message">Message (optional)</label>
                                    <input type="text" class="form-control" id="message" name="message" placeholder="Type here...">
                                </div>
                                <div class="col-md-6">
                                    <label for="mode_of_payment_id"><span class="text-danger me-1">*</span>Mode of Payment</label>
                                    <select class="form-control" id="mode_of_payment_id" name="mode_of_payment_id" required>
                                        <?php
                                        $stmt = $conn->prepare(' SELECT * FROM tbl_mode_of_payment ');
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($rows = $result->fetch_assoc()) {
                                            $mode_of_payment_id = $rows['mode_of_payment_id'];
                                            $mode_of_payment = $rows['mode_of_payment'];
                                            echo "
                                            <option value='$mode_of_payment_id'>$mode_of_payment</option>
                                        ";
                                        }
                                        ?>
                                    </select>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#qrModal">View QR Code</a>
                                </div>
                                <div class="col-md-6">
                                    <label for="evidence"><span class="text-danger me-1">*</span>Payment evidence</label>
                                    <input type="file" class="form-control" id="evidence" name="evidence" required>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary rounded-5 p-3 mt-3 w-50">Submit &nbsp;<i class="bi bi-telegram"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" tabindex="-1" id="qrModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">C-chen Paradise Beach Resort QR Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="assets/img/qr.png" width="300" alt="QR Code" id="qrCode">
                            <p class="mt-5"><i>Note: To proceed, our services required 500 pesos downpayment for legitimate transaction. Thank you for your understanding!</i></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" data-bs-dismiss="modal" onclick="downloadQrFn()">
                            <i class="bi bi-download"></i>&nbsp; Download QR Code
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="footer dark-background">
        <div class="container">
            <h3 class="sitename"><?php include './system-title.php' ?></h3>
            <p>Where Tranquility Meets the Sea – Escape, Relax, and Unwind at C-Chen Beach Resort.</p>
            <div class="social-links d-flex justify-content-center">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-skype"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
            </div>
            <div class="container">
                <div class="copyright">
                    <span>Copyright</span> <strong class="px-1 sitename"><?php include './system-title.php' ?></strong> <span>All Rights
                        Reserved</span>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <script src="assets1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets1/vendor/aos/aos.js"></script>
    <script src="assets1/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets1/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets1/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets1/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets1/js/main.js"></script>

    <script>
        const date_check_in = document.getElementById("date_check_in");
        const date_check_out = document.getElementById("date_check_out");

        document.addEventListener('DOMContentLoaded', function() {
            const dateCheckIn = document.getElementById('date_check_in');
            const dateCheckOut = document.getElementById('date_check_out');
            const today = new Date().toISOString().split('T')[0];
            dateCheckIn.setAttribute('min', today);
            dateCheckIn.addEventListener('change', function() {
                const selectedDate = dateCheckIn.value;
                if (selectedDate) {
                    const nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);
                    const nextDayISO = nextDay.toISOString().split('T')[0];
                    dateCheckOut.removeAttribute('disabled');
                    dateCheckOut.setAttribute('min', nextDayISO);
                } else {
                    dateCheckOut.value = '';
                    dateCheckOut.setAttribute('disabled', true);
                }
            });
        });

        document.getElementById("date_check_in").addEventListener('click', function() {
            this.showPicker();
        });
        document.getElementById("date_check_out").addEventListener('click', function() {
            this.showPicker();
        });

        function downloadQrFn() {
            const qrCodeImage = document.getElementById('qrCode');
            const qrCodeUrl = qrCodeImage.src;
            const downloadLink = document.createElement('a');
            downloadLink.href = qrCodeUrl;
            downloadLink.download = 'C-chen_Paradise_Resort_QR_Code.png';
            downloadLink.click();
        }
    </script>

</body>

</html>