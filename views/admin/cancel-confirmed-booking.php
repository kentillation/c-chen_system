<?php
include '../../config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
  $booking_id = $_GET['booking_id'];
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
        <h1>Cancel Confirmed Booking</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">Menu</li>
            <li class="breadcrumb-item active">Cancel Confirmed Booking</li>
          </ol>
        </nav>
      </div>

      <section class="section dashboard mb-5">
        <a href="bookings.php">
          <i class="bi bi-arrow-left"></i>&nbsp; Back
        </a>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body p-4">
                <form action="../../controller/admin/cancel-confirmation.php?booking_id=<?= $booking_id ?>" method="post">
                  <label for="reason_for_cancellation">Reason for cancellation</label>
                  <textarea name="reason_for_cancellation" id="reason_for_cancellation" class="form-control" rows="5" cols="30" id=""></textarea>
                  <button class="btn btn-sm btn-success px-3 mt-3 rounded-5 ms-1" type="submit">
                    <i class="bi bi-check"></i>&nbsp; Submit
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include 'includes/footer.php' ?>
    <?php include 'includes/scripts.php' ?>
  </body>

  </html>
<?php

} else {
  header('Location: ../../signout.php');
  exit();
}
?>