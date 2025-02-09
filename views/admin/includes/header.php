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
// $firstname = $row['firstname'];
$img_url = $row['img_url'];
?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <a href="calendar" class="logo d-flex align-items-center mx-3">
            <img src="../../assets/img/logo.jpg" alt="Logo" style="border-radius: 7px;">
            <span class="d-none d-lg-block"><?php include '../../system-title.php' ?></span>
        </a>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
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