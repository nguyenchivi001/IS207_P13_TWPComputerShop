<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  include "../Database/db.php";

error_reporting(0);

// Xóa đơn hàng nếu có yêu cầu 'delete'
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $con=OpenCon();
    $order_id = mysqli_real_escape_string($con, $_GET['order_id']);
    $deleteQuery = "DELETE FROM orders WHERE order_id='$order_id'";
    
    if (mysqli_query($con, $deleteQuery)) {
        echo "<script>alert('Order deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting order: " . mysqli_error($con) . "');</script>";
    }
    CloseCon($con);
}

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page1 = ($page > 1) ? ($page * 10) - 10 : 0;

// Giao diện và nội dung
include "sidenav.php";
include "topheader.php";
?>

<!-- Nội dung chính -->
<div class="content">
    <div class="container-fluid">
        <!-- Bảng Activity - User -->
        <?php
        $con=OpenCon();
         generateTable(
            $con,
            "SELECT user_id, email, mobile, last_login, last_logout FROM user_info LIMIT $page1, 10",
            "Activity / Page $page",
            ["User ID", "Email", "Mobile", "Logged In", "Logged Out"]
        ); 
        CloseCon($con)?>

        <!-- Bảng Activity - Supplier -->
        <?php generateTable(
            $con,
            "SELECT user_id, email, mobile, login_time, logout_time FROM user_info LIMIT $page1, 10",
            "Activity / Supplier",
            ["User ID", "Email", "Mobile", "Login Time", "Logout Time"]
        ); ?>
    </div>
</div>

<?php include "footer.php"; ?>

<?php
// Hàm tạo bảng chung
function generateTable($con, $query, $title, $headers) {
    echo "
        <div class='col-md-14'>
            <div class='card'>
                <div class='card-header card-header-primary'>
                    <h4 class='card-title'>$title</h4>
                </div>
                <div class='card-body'>
                    <div class='table-responsive'>
                        <table class='table table-hover tablesorter'>
                            <thead class='text-primary'>
                                <tr>";
    
    // Hiển thị tiêu đề cột
    foreach ($headers as $header) {
        echo "<th>$header</th>";
    }
    
    echo "
                                </tr>
                            </thead>
                            <tbody>";
    
    // Lấy dữ liệu từ database
    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='" . count($headers) . "' style='text-align: center;'>No data available</td></tr>";
    }
    
    echo "
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>";
}
?>


