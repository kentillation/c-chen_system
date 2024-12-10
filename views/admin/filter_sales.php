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

        $confirm = 2;

        $stmt = $conn->prepare('SELECT 
        SUM(trc.room_category_price) AS total_charge,
        tb.booking_status_id
        FROM tbl_booking_room tbr
        INNER JOIN tbl_bookings tb ON tbr.booking_id = tb.booking_id
        INNER JOIN tbl_room_category trc ON tbr.room_category_id = trc.room_category_id
        WHERE DATE(tbr.created_at) = ? AND tb.booking_status_id = ?
        GROUP BY tbr.booking_id');
        $stmt->bind_param('si', $bought_day, $confirm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $today_sales_revenue = 0;
            while ($rows = $result->fetch_assoc()) {
                $total_charge = $rows['total_charge'];
                $today_sales_revenue += $total_charge;
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        $stmt = $conn->prepare('SELECT 
        SUM(trc.room_category_price) AS total_charge,
        tb.booking_status_id
        FROM tbl_booking_room trr
        INNER JOIN tbl_bookings tb ON trr.booking_id = tb.booking_id
        INNER JOIN tbl_room_category trc ON trr.room_category_id = trc.room_category_id
        WHERE DATE_FORMAT(trr.created_at, "%Y-%m") = ?  AND tb.booking_status_id = ?
        GROUP BY trr.booking_id');
        $stmt->bind_param('si', $bought_month, $confirm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $month_sales_revenue = 0;
            while ($rows = $result->fetch_assoc()) {
                $total_charge = $rows['total_charge'];
                $month_sales_revenue += $total_charge;
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        $stmt = $conn->prepare('SELECT 
        SUM(trc.room_category_price) AS total_charge,
        tb.booking_status_id
        FROM tbl_booking_room trr
        INNER JOIN tbl_bookings tb ON trr.booking_id = tb.booking_id
        INNER JOIN tbl_room_category trc ON trr.room_category_id = trc.room_category_id
        WHERE DATE_FORMAT(trr.created_at, "%Y") = ?  AND tb.booking_status_id = ?
        GROUP BY trr.booking_id');
        $stmt->bind_param('si', $bought_year, $confirm);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $year_sales_revenue = 0;
            while ($rows = $result->fetch_assoc()) {
                $total_charge = $rows['total_charge'];
                $year_sales_revenue += $total_charge;
            }
        } else {
            $response['error'] = 'Error executing SQL query.';
        }
        $stmt->close();

        if ($filter === 'sales_today') {
            $response['today_sales_revenue'] = number_format($today_sales_revenue, 2);
        } elseif ($filter === 'sales_thismonth') {
            $response['month_sales_revenue'] = number_format($month_sales_revenue, 2);
        } elseif ($filter === 'sales_thisyear') {
            $response['year_sales_revenue'] = number_format($year_sales_revenue, 2);
        }
    }

    header('Content-Type: application/json'); //Important
    echo json_encode($response);
} else {
    header("Location: ../../");
    exit();
}
