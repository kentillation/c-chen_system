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
          <h1>Announcements</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item">Main</li>
              <li class="breadcrumb-item active">Announcements</li>
            </ol>
          </nav>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
          <i class="bi bi-plus-lg"></i>&nbsp; Add
        </button>
      </div>

      <section class="section dashboard mb-5">
        <div class="row">
          <?php
          $_current_date = date("Y-m-d");
          $stmt = $conn->prepare('SELECT * FROM tbl_announcements ORDER BY id DESC');
          $stmt->execute();
          $result = $stmt->get_result();
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $announcement = $row['announcement'];
            $_created_date = date("Y-m-d", strtotime($row['created_at']));
            $created_at = date("F d, Y h:i A", strtotime($row['created_at']));
            $updated_at = date("F d, Y h:i A", strtotime($row['updated_at']));
            $characterLimit = 70;
            $truncatedAnnouncement = substr($announcement, 0, $characterLimit);
            if (strlen($announcement) > $characterLimit) {
              $truncatedAnnouncement .= '.....';
            }
            $badge_text = '';
            if ($_created_date === $_current_date) {
              $badge_text = 'New';
            }
            echo "
              <div class='col-xxl-3 col-lg-3 col-md-6 col-sm-6'>
                <div class='card pt-2 mb-1'>
                  <span class='badge bg-danger position-relative p-1' style='z-index: 1; margin-top: -18px; width: 30px; font-size: 10px;'>$badge_text</span>
                  <div class='card-body'>
                    <p>$truncatedAnnouncement</p>
                    <div class='text-end'>
                      <button class='btn btn-sm btn-outline-primary' type='button' data-bs-toggle='modal' data-bs-target='#viewAnnounce$id'>
                        <i class='bi bi-eye'></i>
                      </button>
                      <button class='btn btn-sm btn-outline-success' type='button' data-bs-toggle='modal' data-bs-target='#editAnnounce$id'>
                        <i class='bi bi-pencil-square'></i>
                      </button>
                      <button class='btn btn-sm btn-outline-danger' type='button' data-bs-toggle='modal' data-bs-target='#removeAnnounce$id'>
                        <i class='bi bi-trash'></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='viewAnnounce$id'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Announcement</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                      </div>
                      <div class='modal-body'>
                        <div class='container'>
                          <p>$announcement</p>
                          <p class='mt-5'>Date & Time Posted: <br />$created_at</p>
                          <p class='mt-2'>Date & Time Updated: <br />$updated_at</p>
                        </div>
                      </div>
                  </div>
                </div>
              </div>

              <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='editAnnounce$id'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <form action='../../controller/admin/update-announcement-check.php?id=$id' method='post'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Announcement</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                      </div>
                      <div class='modal-body'>
                        <div class='container'>
                          <textarea name='announcement' id='announcementUpdate' class='form-control' col='30' rows='10' required>$announcement</textarea>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <div class='text-end'>
                          <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submitUpdate' type='submit' onclick='submitUpdateFn()'>
                            <span id='update'>Update</span>
                            <div class='d-flex justify-content-center' style='padding: 4px;'>
                              <div class='spinner-border spinner-border-sm' id='loading_update' style='display: none;' role='status'></div>
                            </div>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='removeAnnounce$id'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <form action='../../controller/admin/remove-announcement-check.php?id=$id' method='post'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Announcement</h5>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                      </div>
                      <div class='modal-body'>
                        <div class='container'>
                          <p>Are you sure you want to remove this announcement?</p>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <div class='text-end'>
                          <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submitRemove' type='submit' onclick='submitRemoveFn()'>
                            <span id='remove'>Remove</span>
                            <div class='d-flex justify-content-center' style='padding: 4px;'>
                              <div class='spinner-border spinner-border-sm' id='loading_remove' style='display: none; ' role='status'></div>
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
          if ($result->num_rows == 0) {
            echo '
                <p class="text-center text-secondary mt-3">
                    <i class="bi bi-envelope-open"></i>&nbsp; You have no announcements.
                </p>
                ';
        }
          ?>
        </div>
      </section>

      <div class='modal fade' tabindex='-1' data-bs-backdrop='static' id='addAnnouncementModal'>
        <div class='modal-dialog modal-dialog-centered'>
          <div class='modal-content'>
            <form action='../../controller/admin/announcement-check.php' method='post'>
              <div class='modal-header'>
                <h5 class='modal-title'>Add Announcement</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>
              <div class='modal-body'>
                <div class='container'>
                  <textarea name='announcement' id='announcement' class='form-control' col='30' rows='10' placeholder='Type here...' required></textarea>
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
    if (isset($_GET['updated'])) {
    ?>
      <div id="success-alert-container" style="z-index: 9999;">
        <div id="success-alert">
          <span class="mx-2">
            <i class="bi bi-check-circle me-2"></i>
            <?php echo $_GET['updated'], "Updated successfully."; ?>
          </span>
        </div>
      </div>
    <?php
    }
    if (isset($_GET['remove'])) {
    ?>
      <div id="danger-alert-container" style="z-index: 9999;">
        <div id="danger-alert">
          <span class="mx-2">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?php echo $_GET['remove'], "Remove successfully"; ?>
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
            <?php echo $_GET['success'], "Created successfully."; ?>
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
      let announcement = document.getElementById("announcement");
      let submit = document.getElementById("submit");

      function save_data() {
        const announcementValue = announcement.value.trim();
        if (announcementValue !== '') {
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
      announcement.addEventListener("input", save_data);
      save_data();

      function submitFn() {
        document.getElementById('save').style.display = "none";
        document.getElementById('loading').style.display = "flex";
        document.getElementById('loading').style.alignItems = "center";
        document.getElementById('loading').style.justifyContent = "center";
        document.getElementById('loading').style.cursor = "not-allowed";
        submit.classList.remove("btn-primary");
        submit.classList.add("bg-secondary");
        submit.classList.add("btn");
        submit.style.cursor = "not-allowed";
      }

      let announcementUpdate = document.getElementById("announcementUpdate");
      let submitUpdate = document.getElementById("submitUpdate");

      function update_data() {
        const announcementValue = announcementUpdate.value.trim();
        if (announcementValue !== '') {
          submitUpdate.removeAttribute('disabled');
          submitUpdate.classList.remove("bg-secondary");
          submitUpdate.style.color = "#d9fef2";
          submitUpdate.style.cursor = "pointer";
        } else {
          submitUpdate.setAttribute('disabled', 'disabled');
          submitUpdate.classList.add("bg-secondary");
          submitUpdate.style.color = "#3c3c3c";
          submitUpdate.style.cursor = "not-allowed";
        }
      }
      announcementUpdate.addEventListener("input", update_data);
      update_data();

      function submitUpdateFn() {
        document.getElementById('update').style.display = "none";
        document.getElementById('loading_update').style.display = "flex";
        document.getElementById('loading_update').style.alignItems = "center";
        document.getElementById('loading_update').style.justifyContent = "center";
        document.getElementById('loading_update').style.cursor = "not-allowed";
        submitUpdate.classList.remove("btn-primary");
        submitUpdate.classList.add("bg-secondary");
        submitUpdate.classList.add("btn");
        submitUpdate.style.cursor = "not-allowed";
      }
    </script>
    <script>
      let submitRemove = document.getElementById("submitRemove");

      function submitRemoveFn() {
        document.getElementById('remove').style.display = "none";
        document.getElementById('loading_remove').style.display = "flex";
        document.getElementById('loading_remove').style.alignItems = "center";
        document.getElementById('loading_remove').style.justifyContent = "center";
        document.getElementById('loading_remove').style.cursor = "not-allowed";
        submitRemove.classList.remove("btn-primary");
        submitRemove.classList.add("bg-secondary");
        submitRemove.classList.add("btn");
        submitRemove.style.cursor = "not-allowed";
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