<?php
session_start();
include '../../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 'On');
if (isset($_SESSION['id'])) {
    $response = array();

    if (isset($_POST['filter'])) {
        $filter = $_POST['filter'];
        $bought_day = $_POST['bought_day'];
        $bought_month = $_POST['bought_month'];
        $bought_year = $_POST['bought_year'];

        $day_condition = "DATE(created_at) = ?";
        $month_condition = "DATE_FORMAT(created_at, '%Y-%m') = ?";
        $year_condition = "DATE_FORMAT(created_at, '%Y') = ?";


        $stmt = $conn->prepare(
            'SELECT 
        COUNT(*) AS total_bookings
        FROM tbl_bookings
        WHERE DATE(created_at) = ?'
        );
        $stmt->bind_param('s', $bought_day);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($rows = $result->fetch_assoc()) {
                $todaytotalHistory = $rows['total_bookings'];
                if ($todaytotalHistory > 1) {
                    $today_total_history = number_format($todaytotalHistory) . " customers";
                } else {
                    $today_total_history = number_format($todaytotalHistory) . " customer";
                }
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        $stmt = $conn->prepare(
            'SELECT 
        COUNT(*) AS total_bookings
        FROM tbl_bookings
        WHERE DATE_FORMAT(created_at, "%Y-%m") = ?'
        );
        $stmt->bind_param('s', $bought_month);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($rows = $result->fetch_assoc()) {
                $monthTotalHistory = $rows['total_bookings'];
                if ($monthTotalHistory > 1) {
                    $month_total_history = number_format($monthTotalHistory) . " customers";
                } else {
                    $month_total_history = number_format($monthTotalHistory) . " customer";
                }
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        $stmt = $conn->prepare(
            'SELECT 
        COUNT(*) AS total_bookings
        FROM tbl_bookings
        WHERE DATE_FORMAT(created_at, "%Y") = ?'
        );
        $stmt->bind_param('s', $bought_year);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($rows = $result->fetch_assoc()) {
                $yearTotalHistory = $rows['total_bookings'];
                if ($yearTotalHistory > 1) {
                    $year_total_history = number_format($yearTotalHistory) . " customers";
                } else {
                    $year_total_history = number_format($yearTotalHistory) . " customer";
                }
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        if ($filter === 'res_history_today') {
            $response['today_total_history'] = $today_total_history;
        } elseif ($filter === 'res_history_thismonth') {
            $response['month_total_history'] = $month_total_history;
        } elseif ($filter === 'res_history_thisyear') {
            $response['year_total_history'] = $year_total_history;
        }
    }

    header('Content-Type: application/json'); //Important
    echo json_encode($response);
} else {
    header("Location: ../../");
    exit();
}
