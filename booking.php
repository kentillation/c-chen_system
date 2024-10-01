<?php include './config.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php include './system-title.php' ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- <link href="assets1/img/logo.png" rel="icon"> -->
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
            ?>

        <section class="contact section">
            
            <div class="container section-title" data-aos="fade-up">
                <p>Don’t wait – book now and start your journey to relaxation and rejuvenation!</p>
            </div>
            <div class="container" data-aos="fade" data-aos-delay="100">
                <div class="row gy-4 mx-auto">
                    <div class="col-lg-12">
                        <form action="./controller/save-booking.php" method="post" enctype="multipart/form-data" id="schedule-form" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <input type="hidden" name="id" value="">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="full_name"><span class="text-danger me-1">*</span>Full name</label>
                                    <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Type here..." required>
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
                                    <label for="telephone_number">Telephone number (optional)</label>
                                    <input type="text" name="telephone_number" class="form-control" id="telephone_number" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_check_in"><span class="text-danger me-1">*</span>Date check-in</label>
                                    <input type="datetime-local" name="date_check_in" class="form-control" id="date_check_in" id="date_check_in" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date_check_out"><span class="text-danger me-1">*</span>Date check-out</label>
                                    <input type="datetime-local" name="date_check_out" class="form-control" id="date_check_out" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="service_id"><span class="text-danger me-1">*</span>Service</label>
                                    <select class="form-control" name="service_id" id="service_id" required>
                                        <option selected disabled>-select-</option>
                                        <?php
                                        $stmt = $conn->prepare(' SELECT * FROM tbl_services ');
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        while ($rows = $result->fetch_assoc()) {
                                            $service_id = $rows['service_id'];
                                            $service_name = $rows['service_name'];
                                            echo "
                                            <option value='$service_id'>$service_name</option>
                                        ";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="message">Message (optional)</label>
                                    <input type="text" class="form-control" id="message" name="message" placeholder="Type here..." required>
                                </div>
                                <div class="col-md-6">
                                    <label for="mode_of_payment_id"><span class="text-danger me-1">*</span>Mode of Payment</label>
                                    <select class="form-control" id="mode_of_payment_id" name="mode_of_payment_id" required>
                                        <option selected disabled>-select-</option>
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
                                </div>
                                <div class="col-md-6">
                                    <label for="evidence"><span class="text-danger me-1">*</span>Evidence</label>
                                    <input type="file" class="form-control" id="evidence" name="evidence" required>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="mt-3 w-50">Submit &nbsp;<i class="bi bi-telegram"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
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
        var currentDate = new Date();
        document.getElementById("date_check_in").min = currentDate.toISOString().slice(0, -8);
        document.getElementById("date_check_out").min = currentDate.toISOString().slice(0, -8);
        document.getElementById('date_check_in').addEventListener('click', function() {
            this.showPicker();
        });
        document.getElementById('date_check_out').addEventListener('click', function() {
            this.showPicker();
        });
    </script>

</body>

</html>