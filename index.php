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

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.jpg" width="40" height="100" style="border-radius: 8px;" alt="Logo">
                <h1 class="sitename"><?php include './system-title.php' ?></h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="booking.php" class="custom-button">Book now!</a>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">

            <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown text-white">You've gone to <span>C-Chen Paradise Beach
                                Resort</span></h2>
                        <p class="animate__animated animate__fadeInUp text-white">Welcome to <?php include './system-title.php' ?>, where
                            paradise meets the sea. Unwind in our tranquil beachfront haven, designed for your ultimate relaxation.
                            Experience the beauty of nature and create unforgettable memories with us.</p>
                        <a href="#about"
                            class="btn-get-started animate__animated animate__fadeInUp scrollto bg-primary text-white">Read More</a>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown text-white">About our Services</h2>
                        <p class="animate__animated animate__fadeInUp text-white">At <?php include './system-title.php' ?>, we offer a range
                            of services designed to enhance your stay. From luxurious beachfront accommodations and personalized spa
                            treatments to exciting water sports and guided island tours, we cater to your every need. Whether you're
                            seeking relaxation or adventure, our team is here to make your experience unforgettable.</p>
                        <a href="#services"
                            class="btn-get-started animate__animated animate__fadeInUp scrollto bg-primary text-white">Read More</a>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="carousel-container">
                        <h2 class="animate__animated animate__fadeInDown text-white">Book now at <span>C-Chen Paradise Beach
                                Resort</span></h2>
                        <p class="animate__animated animate__fadeInUp text-white">Booking your stay at <?php include './system-title.php' ?>
                            is easy and convenient. Choose from our range of luxurious accommodations and enjoy flexible booking
                            options tailored to your needs. Reserve your slice of paradise today and prepare for an unforgettable
                            beachside escape.</p>
                        <a href="booking.php"><button
                                class="btn-get-started custom-button animate__animated animate__fadeInUp scrollto bg-info">Book
                                now!</button></a>
                    </div>
                </div>

                <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
                </a>

                <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
                </a>

            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>About</h2>
                <p>Who we are</p>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                        <p>
                            At <?php include './system-title.php' ?>, we are dedicated to providing a serene and unforgettable escape by the
                            sea. Our resort blends comfort, natural beauty, and exceptional service to create a truly relaxing
                            experience for every guest. Whether you're here for a peaceful getaway or an adventure by the shore, we
                            ensure your stay is nothing short of extraordinary.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-circle"></i> <span>Tranquil Beachfront Setting</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Exceptional Guest Experience</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Blend of Comfort and Nature</span></li>
                            <li><i class="bi bi-check2-circle"></i> <span>Unforgettable Activities</span></li>
                        </ul>
                    </div>
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <p>Booking your stay at <?php include './system-title.php' ?> is easy and convenient. Choose from our range of
                            luxurious accommodations and enjoy flexible booking options tailored to your needs. Reserve your slice of
                            paradise today and prepare for an unforgettable beachside escape.</p>
                        <a href="booking.php"><button class="custom-button">Book now!</button></a>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Features Section -->
        <section id="features" class="features section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Services</h2>
                <p>What we do offer</p>
            </div>

            <div class="container">
                <ul class="nav nav-tabs row  d-flex" data-aos="fade-up" data-aos-delay="100">
                    <li class="nav-item col-3">
                        <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                            <i class="bi bi-water"></i>
                            <h4 class="d-none d-lg-block">Tranquil Beachfront Setting</h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                            <i class="bi bi-emoji-smile"></i>
                            <h4 class="d-none d-lg-block">Exceptional Guest Experience</h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                            <i class="bi bi-tree"></i>
                            <h4 class="d-none d-lg-block">Blend of Comfort and Nature</h4>
                        </a>
                    </li>
                    <li class="nav-item col-3">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-4">
                            <i class="bi bi-tsunami"></i>
                            <h4 class="d-none d-lg-block">Unforgettable Activities</h4>
                        </a>
                    </li>
                </ul><!-- End Tab Nav -->

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                    <div class="tab-pane fade active show" id="features-tab-1">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                                <h3>Our resort offers a peaceful escape surrounded by the beauty of pristine beaches and calming ocean
                                    views.</h3>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i><span>Enjoy exclusive access to our pristine, soft white sands and
                                            crystal-clear waters.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Wake up to breathtaking sunrises and fall asleep to the
                                            calming sound of waves from your room.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Escape the crowds and unwind in a peaceful, serene
                                            environment perfect for relaxation.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Relax under shaded cabanas or soak up the sun on our
                                            comfortable lounge chairs by the shore.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets1/img/features/img1.jpg" alt="" width="600" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End Tab Content Item -->

                    <div class="tab-pane fade" id="features-tab-2">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                                <h3>We pride ourselves on delivering top-notch service and creating memorable experiences for every
                                    guest.</h3>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Our attentive staff ensures every detail of your stay is
                                            tailored to your preferences.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Whether it's a late-night request or early morning inquiry,
                                            we're always available to help.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Savor delicious meals crafted by our expert chefs,
                                            featuring local and international cuisines.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Enjoy a smooth and hassle-free experience from the moment
                                            you arrive until your departure.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets1/img/features/img2.jpg" alt="" width="600" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End Tab Content Item -->

                    <div class="tab-pane fade" id="features-tab-3">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                                <h3>Enjoy modern amenities while staying connected to the natural beauty of the seaside environment.
                                </h3>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Stay in rooms designed with sustainable materials while
                                            offering modern amenities.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Experience nature up close with our outdoor lounges, dining
                                            areas, and beachfront access.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Enjoy plush bedding, climate control, and stylish interiors
                                            that blend seamlessly with the natural surroundings.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Relax in an environment where lush greenery and ocean
                                            breezes enhance your sense of peace and well-being.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets1/img/features/img3.jpg" alt="" width="600" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End Tab Content Item -->

                    <div class="tab-pane fade" id="features-tab-4">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                                <h3>From relaxing by the pool to enjoying our versatile event spaces, <?php include './system-title.php' ?>
                                    offers activities and amenities to suit every guest's preference.</h3>
                                <ul>
                                    <li><i class="bi bi-check2-all"></i> <span>Host memorable events, conferences, or celebrations in our
                                            versatile hall space</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Enjoy refreshing swims and poolside relaxation in our
                                            charming mini swimming pool.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Find solace and tranquility in our serene mini church,
                                            perfect for personal reflection or small ceremonies.</span></li>
                                    <li><i class="bi bi-check2-all"></i> <span>Unwind with a selection of refreshing beverages and
                                            cocktails at our cozy mini bar, ideal for socializing or relaxing after a day of
                                            activities.</span></li>
                                </ul>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="assets1/img/features/img4.jpg" alt="" width="600" class="img-fluid">
                            </div>
                        </div>
                    </div><!-- End Tab Content Item -->

                </div>

            </div>

        </section><!-- /Features Section -->

        <!-- FREQUENTLY ASKED QUESTIONS Section -->
        <section id="faq" class="faq section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Frequently Asked Questions</h2>
                <p>Frequently Asked Questions</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-accordion" id="accordion-faq">
                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-1">
                                        What amenities are available at <?php include './system-title.php' ?>?
                                    </button>
                                </h2>

                                <div id="collapse-faq-1" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        We offer a range of amenities, including a mini swimming pool, a hall for events and gatherings, a
                                        mini church for personal reflection or small ceremonies, and a mini bar for relaxing with
                                        refreshments.
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-faq-2">
                                        How can I make a reservation at <?php include './system-title.php' ?>?
                                    </button>
                                </h2>
                                <div id="collapse-faq-2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        You can easily book your stay through this page or by contacting our reservations team directly. We
                                        offer flexible booking options to suit your needs.
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-faq-3">
                                        Is <?php include './system-title.php' ?> family-friendly?
                                    </button>
                                </h2>

                                <div id="collapse-faq-3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        Yes, our resort is perfect for families. We provide comfortable accommodations, a swimming pool, and
                                        a peaceful atmosphere that guests of all ages will enjoy.
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-faq-4">
                                        Can I host events at <?php include './system-title.php' ?>?
                                    </button>
                                </h2>

                                <div id="collapse-faq-4" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        Absolutely! Our spacious hall is ideal for hosting events such as weddings, corporate gatherings, and special celebrations. We can help tailor the venue to meet your specific requirements.
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                            <div class="accordion-item">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse-faq-5">
                                        Does the resort offer dining options?
                                    </button>
                                </h2>

                                <div id="collapse-faq-5" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                    <div class="accordion-body">
                                        Yes, we have a mini bar where you can enjoy a selection of drinks and light refreshments. For additional dining options, we can recommend nearby restaurants and cafés.
                                    </div>
                                </div>
                            </div>
                            <!-- .accordion-item -->

                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Faq Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Address</h3>
                                <p>Brgy. Old Sagay, Sagay City 6122 Philippines</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-phone flex-shrink-0"></i>
                            <div>
                                <h3>Phone Number</h3>
                                <p>+63 123 456 7891</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Telephone Number</h3>
                                <p>000-222-333</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>info@example.com</p>
                            </div>
                        </div><!-- End Info Item -->

                    </div>

                    <div class="col-lg-8">
                        <form action="./controller/#" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <!-- Footer -->
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

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets1/vendor/php-email-form/validate.js"></script>
    <script src="assets1/vendor/aos/aos.js"></script>
    <script src="assets1/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets1/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets1/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets1/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets1/js/main.js"></script>

</body>

</html>