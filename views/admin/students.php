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
                <h1>Students Masterlist</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Students</li>
                        <li class="breadcrumb-item active">Students Masterlist</li>
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
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="15%">
                                            <col width="10%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Username</th>
                                                    <th>Email</th>
                                                    <th class='text-center'>Account Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $stmt = $conn->prepare(' SELECT * FROM tbl_student ORDER BY student_id ASC');
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $num = 0;
                                                while ($row = $result->fetch_assoc()) {
                                                    $num++;
                                                    $student_id = $row['student_id'];
                                                    $firstname = $row['firstname'];
                                                    $middlename = $row['middlename'];
                                                    $lastname = $row['lastname'];
                                                    $user_name = $row['user_name'];
                                                    $email = $row['email'];
                                                    $account_status = $row['account_status'];
                                                    $created_at = $row['created_at'];
                                                    if ($account_status == 1) {
                                                        $status_text = 'Pending';
                                                        $status_indicator = 'badge bg-danger text-white';
                                                    }
                                                    if ($account_status == 2) {
                                                        $status_text = 'Active';
                                                        $status_indicator = 'badge bg-success text-white';
                                                    } else {
                                                        $status_text = 'Inactive';
                                                        $status_indicator = 'badge bg-warning text-white';
                                                    }
                                                    echo "
                                                            <tr>
                                                                <td>$num</td>
                                                                <td>$firstname $middlename $lastname</td>
                                                                <td>$user_name</td>
                                                                <td>$email</td>
                                                                <td class='text-center'><span class='$status_indicator'>$status_text</span></td>
                                                            </tr>
                                                        ";
                                                ?>
                                                    <div class="modal fade" tabindex="-1" aria-label="false" id="editModal<?php echo $student_id ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="../../controller/admin/update-student.php?student_id=<?php echo $student_id ?>" method="post">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Student Inforamation</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="form-group mb-3">
                                                                                <label for="firstname" class="control-label text-secondary">First Name</label>
                                                                                <input type="text" class="form-control form-control-sm" name="firstname" value="<?php echo $firstname ?>" id="firstname" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="middlename" class="control-label text-secondary">Middle Name</label>
                                                                                <input type="text" class="form-control form-control-sm" name="middlename" value="<?php echo $middlename ?>" id="middlename" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="lastname" class="control-label text-secondary">Last Name</label>
                                                                                <input type="text" class="form-control form-control-sm" name="lastname" value="<?php echo $lastname ?>" id="lastname" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="user_name" class="control-label text-secondary">User_name</label>
                                                                                <input type="text" class="form-control form-control-sm" name="user_name" value="<?php echo $user_name ?>" id="user_name" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="email" class="control-label text-secondary">Email</label>
                                                                                <input type="email" class="form-control form-control-sm" name="email" value="<?php echo $email ?>" id="email" required>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                                <label for="account_status" class="control-label text-secondary">Status</label>
                                                                                <select class="form-control form-control-sm" name="account_status" required>
                                                                                    <option value="<?php echo $account_status ?>"><?php echo $status_text ?></option>
                                                                                    <option value="1">Active</option>
                                                                                    <option value="2">Inactive</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <div class="text-end">
                                                                            <button class='btn btn-primary w-100 d-flex align-items-center justify-content-center rounded-5' id='submitUpdate' type='submit' onclick='submitUpdateFn()'>
                                                                                <span id='update'>Update</span>
                                                                                <div class='d-flex justify-content-center'>
                                                                                    <div class='spinner-border spinner-border-sm' id='loading_update' style='display: none; padding: 4px;' role='status'></div>
                                                                                </div>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php
                                        if ($result->num_rows == 0) {
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

        <?php include 'includes/footer.php' ?>

        <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/main.js"></script>
        <script>
            let submitUpdate = document.getElementById("submitUpdate");

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

    </body>

    </html>
<?php
} else {
    header('Location: ../../signout');
    exit();
}
?>