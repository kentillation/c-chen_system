<!DOCTYPE html>
<html lang="en">

<head>
    <title>Poturo App</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Poturo</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/logo.png" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container starters">
            <section class="section min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex align-items-center flex-column">
                                <img src="assets/img/logo.png" alt="" width="100">
                                <div class="mt-3 text-center">
                                    <h6 class="fs-3 my-3">
                                        <strong>SNHS Poturo App</strong>
                                    </h6>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center fs-2">A D M I N</h5>
                                    <form action="controller/admin/admin-signup-check.php" method="post" class="row g-3">
                                        <div class="col-12 mb-2">
                                            <label for="email" class="">Email</label>
                                            <?php if (isset($_GET['email'])) { ?>
                                                <input type="email" name="email" class="form-control" id="email" value="<?php echo $_GET['email']; ?>" style="border-bottom: 1px solid #ff0000;" required>
                                            <?php
                                            } else { ?>
                                                <input type="email" name="email" class="form-control" id="email" required />
                                            <?php
                                            } ?>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="user_name" class="">User_name</label>
                                            <?php if (isset($_GET['user_name'])) { ?>
                                                <input type="text" name="user_name" class="form-control" id="user_name" value="<?php echo $_GET['user_name']; ?>" style="border-bottom: 1px solid #ff0000;" required>
                                            <?php
                                            } else { ?>
                                                <input type="text" name="user_name" class="form-control" id="user_name" required />
                                            <?php
                                            } ?>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <label for="password" class="">Password</label>
                                            <div class="input-group">
                                                <?php if (isset($_GET['password'])) { ?>
                                                    <input type="password" name="password" class="form-control" id="password" value="<?php echo $_GET['password']; ?>" style="border-bottom: 1px solid #ff0000;" autocomplete required />
                                                <?php
                                                } else { ?>
                                                    <input type="password" name="password" class="form-control" id="password" autocomplete required />
                                                <?php
                                                } ?>
                                                <span class="toggle-pass position-absolute" style="bottom: 0; right: 5px;">
                                                    <button class="btn form-control" type="button" id="toggle-password" style="z-index: 9999;">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn-starter w-100 d-flex align-items-center justify-content-center rounded-5" id="submit" type="submit" onclick="submitFn()">
                                                <span id="login">Create</span>
                                                <div class="d-flex justify-content-center" style="padding: 4px;">
                                                    <div class="spinner-border spinner-border-sm" id="loading" role="status"></div>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="admin-login" class="small">
                                                <i class="bi bi-arrow-left"></i>&nbsp; Back to sign-in
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <?php
        if (isset($_GET['success'])) {
        ?>
            <div id="success-alert-container">
                <div id="success-alert">
                    <span class="mx-2">
                        <i class="bi bi-check-circle me-2"></i>
                        <?php echo $_GET['success'], "Account created successfully."; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        if (isset($_GET['registered'])) {
        ?>
            <div id="danger-alert-container">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $_GET['registered'], "User_name already registered."; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        if (isset($_GET['unknown'])) {
        ?>
            <div id="danger-alert-container">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-x-circle me-2"></i>
                        <?php echo $_GET['unknown'], "Unknown error occured."; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        ?>
    </footer>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        let user_name = document.getElementById("user_name");
        let password = document.getElementById("password");
        let submit = document.getElementById("submit");

        function login_data() {
            const user_nameValue = user_name.value.trim();
            const passwordValue = password.value.trim();
            if (user_nameValue !== '' && passwordValue !== '') {
                submit.removeAttribute('disabled');
                submit.classList.remove("bg-secondary");
                submit.style.color = "#d9fef2";
                submit.style.cursor = "pointer";
            } else {
                submit.setAttribute('disabled', 'disabled');
                submit.classList.add("bg-secondary");
                submit.style.color = "#3c3c3c";
                submit.style.cursor = "not-allowed";
            }
        }
        user_name.addEventListener("input", login_data);
        password.addEventListener("input", login_data);
        login_data();

        function submitFn() {
            document.getElementById('login').style.display = "none";
            document.getElementById('loading').style.display = "flex";
            document.getElementById('loading').style.alignItems = "center";
            document.getElementById('loading').style.justifyContent = "center";
            submit.classList.remove("btn-starter");
            submit.classList.add("bg-secondary");
            submit.classList.add("btn");
        }

        const togglePassword = document.querySelector('#toggle-password');
        const passwordField = document.querySelector('#password');
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });

        function convertToLowerCase() {
            var input = document.getElementById("user_name");
            input.value = input.value.toLowerCase();
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
    <script>
        let success_alert = document.getElementById("success-alert-container");
        success_alert.style.bottom = "10px";
        success_alert.style.transition = "0.5s all ease";
        setTimeout(function() {
            success_alert.style.bottom = "-70px";
            success_alert.style.transition = "0.5s all ease";
        }, 7000);
    </script>
</body>

</html>