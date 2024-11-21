<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
  $id = $_SESSION['id'];

  $stmt = $conn->prepare('SELECT * FROM tbl_admin WHERE id = ?');
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $email = $row['email'];
  $user_name = $row['user_name'];
  $firstname = $row['firstname'];
  $middlename = $row['middlename'];
  $lastname = $row['lastname'];
  $img_url = $row['img_url'];
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
        <h1>Profile</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Main</li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </nav>
      </div>
      
      <section class="section profile mb-5">
        <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <form action="../../controller/admin/update-pp-check.php" method="post" enctype="multipart/form-data">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                  <img src="profile-pictures/<?= $img_url ?>" alt="Profile" class="rounded-circle" style="width: 160px; height: 120px;" id="uploadedImg">
                  <div class="pt-2">
                    <label for="upload" class="btn btn-outline-primary btn-sm" tabindex="0">
                      <i class="bi bi-upload"></i></i>
                      <input name="img_url" type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
                    </label>
                    <button class="btn btn-outline-danger btn-sm image-reset" type="button" title="Remove profile image"><i class="bi bi-trash"></i></button>
                  </div>
                  <button type="submit" class="btn btn-sm btn-primary px-5 py-1 mt-1 mb-4 rounded-5">Save</button>
                  <h2><?php echo $firstname . ' ' . $middlename . ' ' . $lastname ?></h2>
                  <h3 class="mt-2"><?php echo $user_name ?></h3>
                  <a href="#" style="text-decoration: underline; font-size: 12px;" data-bs-toggle="modal" data-bs-target="#editUser_nameModal">Edit user_name</a>
                </div>
              </form>
            </div>

          </div>

          <div class="col-xl-8">
            <div class="card">
              <div class="card-body pt-3">
                <ul class="nav nav-tabs nav-tabs-bordered">

                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Password</button>
                  </li>

                </ul>
                <div class="tab-content pt-2">

                  <div class="tab-pane fade show active profile-overview" id="profile-overview">

                    <h5 class="card-title">Profile Details</h5>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Full Name</div>
                      <div class="col-lg-9 col-md-8"><?php echo $firstname . " " . $middlename . " " . $lastname ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label ">Username</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_name ?></div>
                    </div>

                    <div class="row">
                      <div class="col-lg-3 col-md-4 label">Email</div>
                      <div class="col-lg-9 col-md-8"><?php echo $email ?></div>
                    </div>

                  </div>

                  <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                    <form action="../../controller/admin/update-profile-check.php?<?php echo $id ?>" method="post">

                      <div class="row mb-3">
                        <label for="firstname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="firstname" type="text" class="form-control" id="firstname" value="<?php echo $firstname ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="middlename" class="col-md-4 col-lg-3 col-form-label">Middle Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="middlename" type="text" class="form-control" id="middlename" value="<?php echo $middlename ?>">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="lastname" type="text" class="form-control" id="lastname" value="<?php echo $lastname ?>">
                        </div>
                      </div>

                      <div class="text-center">
                        <button class='btn-primary px-4 rounded-5' id='submitProfile' type='submit' onclick='submitProfileFn()'>
                          <span id='saveProfile' class='text-white'>Save Profile</span>
                          <div class='d-flex justify-content-center'>
                            <div class='spinner-border spinner-border-sm' id='loading' style='margin: 4px;' role='status'></div>
                          </div>
                        </button>
                      </div>
                    </form>

                  </div>

                  <div class="tab-pane fade pt-3" id="profile-change-password">
                    <form action="../../controller/admin/update-password-check?id=<?= $id ?>" method="post">

                      <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="current_password" type="password" class="form-control" id="currentPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="newpassword" type="password" class="form-control" id="newPassword">
                        </div>
                      </div>

                      <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                        <div class="col-md-8 col-lg-9">
                          <input name="renewpassword" type="password" class="form-control" id="renewPassword" required>
                        </div>
                      </div>

                      <div class="text-center">
                        <button class='btn-primary px-4 rounded-5' id='submitPassword' type='submit' onclick='submitPasswordFn()'>
                          <span id='savePassword' class='text-white'>Change Password</span>
                          <div class='d-flex justify-content-center'>
                            <div class='spinner-border spinner-border-sm' id='loading_password' style='margin: 4px; display: none;' role='status'></div>
                          </div>
                        </button>
                      </div>
                    </form>

                  </div>

                </div>

              </div>
            </div>

          </div>
        </div>

        <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='editUser_nameModal'>
          <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
              <form action='../../controller/admin/update-username-check.php' method='post'>
                <div class='modal-header'>
                  <h5 class='modal-title'>Edit Username</h5>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                  <div class="form-group mb-2">
                    <label for="user_name" class="control-label">Username</label>
                    <input type="text" name="user_name" id="user_name" value="<?php echo $user_name ?>" class="form-control" required>
                  </div>
                </div>
                <div class='modal-footer'>
                  <div class='text-end'>
                    <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submit' type='submit' onclick='submitFn()'>
                      <span id='save'>Save</span>
                      <div class='d-flex justify-content-center' style='padding: 4px;'>
                        <div class='spinner-border spinner-border-sm' id='loading_user' style="display: none;" role='status'></div>
                      </div>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php
    if (isset($_GET['updated_pp'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['updated_pp'], "Photo updated successfully."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['too_large'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['too_large'], "File is too large."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['invalid_file_type'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['invalid_file_type'], "Invalid type of file."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['updated'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['updated'], "Profile updated successfully."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['registered'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['registered'], "Account already registered."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['registered_user_name'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['registered_user_name'], "User_name already registered."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['updated_user_name'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['updated_user_name'], "User_name updated successfully."; ?>
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
    if (isset($_GET['unchange'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['unchange'], "No changes in profile picture."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['invalid_current_password'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['invalid_current_password'], "Invalid current password."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['mismatch_passwords'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['mismatch_passwords'], "Re-enter new password mismatch."; ?>
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
      document.addEventListener('DOMContentLoaded', function(e) {
        (function() {
          let accountUserImage = document.getElementById('uploadedImg');
          const fileInput = document.querySelector('.account-file-input'),
            resetFileInput = document.querySelector('.image-reset');
          if (accountUserImage) {
            const resetImage = accountUserImage.src;
            fileInput.onchange = () => {
              if (fileInput.files[0]) {
                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
              }
            };
            resetFileInput.onclick = () => {
              fileInput.value = '';
              accountUserImage.src = resetImage;
            };
          }
        })();
      });
    </script>

    <script>
      let user_name = document.getElementById("user_name");
      let submit = document.getElementById("submit");

      function save_user_name() {
        const user_nameValue = user_name.value.trim();
        if (user_nameValue !== '') {
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
      user_name.addEventListener("input", save_user_name);
      save_user_name();

      function submitFn() {
        document.getElementById('save').style.display = "none";
        document.getElementById('loading_user').style.display = "flex";
        document.getElementById('loading_user').style.alignItems = "center";
        document.getElementById('loading_user').style.justifyContent = "center";
        document.getElementById('loading_user').style.cursor = "not-allowed";
        submit.classList.remove("btn-primary");
        submit.classList.add("bg-secondary");
        submit.classList.add("btn");
      }
    </script>

    <script>
      let firstname = document.getElementById("firstname");
      let middlename = document.getElementById("middlename");
      let lastname = document.getElementById("lastname");
      let submitProfile = document.getElementById("submitProfile");

      function save_data() {
        const firstnameValue = firstname.value.trim();
        const middlenameValue = middlename.value.trim();
        const lastnameValue = lastname.value.trim();
        if (firstnameValue !== '' && middlenameValue !== '' && lastnameValue !== '') {
          submitProfile.removeAttribute('disabled');
          submitProfile.classList.remove("bg-secondary");
          submitProfile.style.color = "#d9fef2";
          submitProfile.style.cursor = "pointer";
        } else {
          submitProfile.setAttribute('disabled', 'disabled');
          submitProfile.classList.add("bg-secondary");
          submitProfile.style.color = "#3c3c3c";
          submitProfile.style.cursor = "not-allowed";
        }
      }
      firstname.addEventListener("input", save_data);
      middlename.addEventListener("input", save_data);
      lastname.addEventListener("input", save_data);
      save_data();

      function submitProfileFn() {
        document.getElementById('saveProfile').style.display = "none";
        document.getElementById('loading').style.display = "flex";
        document.getElementById('loading').style.alignItems = "center";
        document.getElementById('loading').style.justifyContent = "center";
        document.getElementById('loading').style.cursor = "not-allowed";
        submit.classList.remove("btn-primary");
        submit.classList.add("bg-secondary");
        submit.classList.add("btn");
        submit.style.cursor = "not-allowed";
      }
    </script>

    <script>
      let submitPassword = document.getElementById("submitPassword");

      function submitPasswordFn() {
        document.getElementById('savePassword').style.display = "none";
        document.getElementById('loading_password').style.display = "flex";
        document.getElementById('loading_password').style.alignItems = "center";
        document.getElementById('loading_password').style.justifyContent = "center";
        document.getElementById('loading_password').style.cursor = "not-allowed";
        submitPassword.classList.remove("btn-primary");
        submitPassword.classList.add("bg-secondary");
        submitPassword.classList.add("btn");
        submitPassword.style.cursor = "not-allowed";
      }
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
  header('Location: ../../signout.php');
  exit();
}
?>