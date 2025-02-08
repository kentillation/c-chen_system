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

      <div class="pagetitle d-flex align-items-center justify-content-between">
        <div>
          <h1>Admin Accounts</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Main</li>
              <li class="breadcrumb-item active">Admin Accounts</li>
            </ol>
          </nav>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addNewAdmin">
          <i class="bi bi-plus-lg"></i>&nbsp; Add
        </button>
      </div>

      <section class="section dashboard mb-5">
        <div class="row">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <div class="table-responsive">
                <table class="table">
                  <col width="10%">
                  <col width="45%">
                  <col width="45%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Email</th>
                      <th>Username</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $admin_id = $_SESSION['id'];
                    $stmt = $conn->prepare('SELECT * FROM tbl_admin WHERE id <> ? ORDER BY id ASC');
                    $stmt->bind_param('i', $admin_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $num = 0;
                    while ($row = $result->fetch_assoc()) {
                      $num++;
                      $id = $row['id'];
                      $user_name = $row['user_name'];
                      $email = $row['email'];
                      echo "
                      <tr>
                          <td>$num</td>
                          <td>$email</td>
                          <td>$user_name</td>
                      </tr>
                        ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='addNewAdmin'>
        <div class='modal-dialog modal-dialog-centered'>
          <div class='modal-content'>
            <form action='../../controller/admin/admin-account-check.php' method='post'>
              <div class='modal-header'>
                <h5 class='modal-title'>Add New Admin</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                <div class='container'>
                  <div class="form-group mb-2">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Type here..." required>
                  </div>
                  <div class="form-group mb-2">
                    <label for="user_name" class="control-label">Username</label>
                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Type here..." required>
                  </div>
                  <div class="form-group mb-2">
                    <label for="password" class="control-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Type here..." required>
                  </div>
                </div>
              </div>
              <div class='modal-footer'>
                <div class='text-end'>
                  <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submit' type='submit' onclick='submitFn()'>
                    <span id='save'>Save</span>
                    <div class='d-flex justify-content-center' style='padding: 4px;'>
                      <div class='spinner-border spinner-border-sm' id='loading' role='status'></div>
                    </div>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php
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
    if (isset($_GET['error'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['error'], "Unknown error occured."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['success'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['success'], "Admin Created successfully."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    ?>

    <?php include 'includes/footer.php' ?>
    <?php include 'includes/scripts.php' ?>

    <script>
      let email = document.getElementById("email");
      let user_name = document.getElementById("user_name");
      let password = document.getElementById("password");
      let submit = document.getElementById("submit");

      function save_data() {
        const emailValue = email.value.trim();
        const user_nameValue = user_name.value.trim();
        const passwordValue = password.value.trim();
        if (emailValue !== '' && user_nameValue !== '' && passwordValue !== '') {
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
      email.addEventListener("input", save_data);
      user_name.addEventListener("input", save_data);
      password.addEventListener("input", save_data);
      save_data();

      function submitFn() {
        document.getElementById('save').style.display = "none";
        document.getElementById('loading').style.display = "flex";
        document.getElementById('loading').style.alignItems = "center";
        document.getElementById('loading').style.justifyContent = "center";
        submit.classList.remove("btn-primary");
        submit.classList.add("bg-secondary");
        submit.classList.add("btn");
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
  header('Location: ../../');
  exit();
}
?>