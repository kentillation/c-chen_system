<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php include './system-title.php' ?></title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/logo.jpg" rel="icon">
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
                                <img src="assets/img/logo.jpg" alt="" width="100" style="border-radius: 50%;">
                                <div class="mt-3 text-center">
                                    <h5 class="my-3">
                                        <strong><?php include './system-title.php' ?></strong>
                                    </h5>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title text-center fs-2">A D M I N</h5>
                                    <form action="controller/admin/admin-login-check.php" method="post" class="row g-3" novalidate>
                                        <div class="col-12 mb-3">
                                            <label for="user_name" class="">Username</label>
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
                                                <?php if (isset($_GET['user_name'])) { ?>
                                                    <input type="password" name="password" class="form-control" id="password" style="border-bottom: 1px solid #ff0000;" autocomplete required />
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
                                            <div class="d-flex align-items-center flex-column">
                                                <button class="btn-starter w-50 d-flex align-items-center justify-content-center rounded-5 mb-3" id="submitBtn" type="submit" onclick="submitFn()">
                                                    <span id="login">Sign-in</span>
                                                    <div class="d-flex justify-content-center" style="padding: 4px;">
                                                        <div class="spinner-border spinner-border-sm" id="loading" role="status"></div>
                                                    </div>
                                                </button>
                                            </div>
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
        if (isset($_GET['invalid'])) {
        ?>
            <div id="danger-alert-container">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $_GET['invalid'], "Invalid credentials"; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        if (isset($_GET['error'])) {
        ?>
            <div id="danger-alert-container">
                <div id="danger-alert">
                    <span class="mx-2">
                        <i class="bi bi-exclamation-circle me-2"></i>
                        <?php echo $_GET['error']; ?>
                    </span>
                </div>
            </div>
        <?php
        }
        if (isset($_GET['user_name_changed'])) {
            ?>
                <div id="success-alert-container">
                    <div id="success-alert">
                        <span class="mx-2">
                            <i class="bi bi-check-circle me-2"></i>
                            <?php echo $_GET['user_name_changed'], "Username changed successfully."; ?>
                        </span>
                    </div>
                </div>
            <?php
            }
        if (isset($_GET['password_changed'])) {
        ?>
            <div id="success-alert-container">
                <div id="success-alert">
                    <span class="mx-2">
                        <i class="bi bi-check-circle me-2"></i>
                        <?php echo $_GET['password_changed'], "Password changed successfully."; ?>
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
        const user_name = document.getElementById("user_name");
        const password = document.getElementById("password");
        const submit = document.getElementById("submitBtn");

        // Function to check if both fields are filled
		function isFilled() {
			const user_nameValue = user_name.value.trim();
			const passwordValue = password.value.trim();
			return user_nameValue !== '' && passwordValue !== '';
		}

        // Function to toggle the submit button based on form input
        function toggleSubmitButton() {
			if (isFilled()) {
				submit.disabled = false;
				submit.style.cursor = "pointer";
				submit.style.color = "#d9fef2";
                submit.classList.remove("bg-secondary");
			} else {
				submit.disabled = true;
				submit.style.cursor = "not-allowed";
				submit.style.color = "#3c3c3c";
                submit.classList.add("bg-secondary");
			}
		}

        // Function to handle the form submission
		function submitFn() {
			submit.disabled = true;
			submit.style.cursor = "not-allowed";
            submit.classList.add("bg-secondary");
			document.getElementById('login').style.display = "none";
			document.getElementById('loading').style.display = "flex";
			document.getElementById('loading').style.color = "#3c3c3c";
            submit.form.submit();
		}

		// Attach event listeners to input fields
		user_name.addEventListener("input", toggleSubmitButton);
		password.addEventListener("input", toggleSubmitButton);

		// Initial call to set the button state correctly on page load
		toggleSubmitButton();

		// Attach the submitFn to the form's submit event
		const form = document.querySelector('form');
		form.addEventListener('submit', submitFn);

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
        const danger_alert = document.getElementById("danger-alert-container");
        danger_alert.style.bottom = "10px";
        danger_alert.style.transition = "0.5s all ease";
        setTimeout(function() {
            danger_alert.style.bottom = "-70px";
            danger_alert.style.transition = "0.5s all ease";
        }, 7000);
    </script>
    <script>
        const success_alert = document.getElementById("success-alert-container");
        success_alert.style.bottom = "10px";
        success_alert.style.transition = "0.5s all ease";
        setTimeout(function() {
            success_alert.style.bottom = "-70px";
            success_alert.style.transition = "0.5s all ease";
        }, 7000);
    </script>
</body>

</html>