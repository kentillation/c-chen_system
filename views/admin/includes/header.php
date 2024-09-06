<?php
include "../../config.php";
error_reporting(E_ALL);
ini_set('display_errors', 'On');
$id = $_SESSION['id'];
$stmt = $conn->prepare('SELECT * FROM tbl_admin WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$firstname = $row['firstname'];
$img_url = $row['img_url'];
?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <a href="calendar" class="logo d-flex align-items-center mx-3">
            <img src="../../assets/img/logo.png" alt="Logo" style="border-radius: 7px;">
            <span class="d-none d-lg-block"><?php include '../../system-title.php' ?></span>
        </a>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <?php
                    $current_date = new DateTime();
                    $interval = new DateInterval('P7D');
                    $current = $current_date->format('Y-m-d H:i:s');
                    $stmt = $conn->prepare('SELECT * FROM schedule_list WHERE start_datetime <= DATE_ADD(NOW(), INTERVAL 7 DAY) ORDER BY start_datetime ASC');
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $event_notifs = $result->num_rows;
                    if ($event_notifs > 0) {
                        echo "<span class='badge bg-danger badge-number'>$event_notifs</span>";
                    }
                    ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        Notifications
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php
                    if ($event_notifs > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $start_datetime = new DateTime($row['start_datetime']);
                            $start_datetime->sub($interval);
                            if ($start_datetime < $current_date) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $start_datetime_formatted = date("F d, Y h:i A", strtotime($row['start_datetime']));
                                echo "
                                <li class='notification-item'>
                                    <i class='bi bi-bell text-warning'></i>
                                    <div>
                                        <h4>$title</h4>
                                        <p>$start_datetime_formatted</p>
                                    </div>
                                </li>
                            ";
                            }
                        }
                    } else {
                        echo '<p class="text-center mt-2"><i class="bi bi-trash"></i>&nbsp; Empty</p>';
                    }
                    ?>
                </ul>
            </li>
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="profile-pictures/<?= $img_url ?>" alt="Profile" style="width: 38px; height: 40px;" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>Administrator</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="profile">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../../signout">
                            <i class="bi bi-box-arrow-left"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>