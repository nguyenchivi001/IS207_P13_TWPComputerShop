<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../Database/db_connection.php";

// Xóa quản trị viên nếu có yêu cầu
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $admin_id = intval($_GET['admin_id']); // Đảm bảo $admin_id là số nguyên
    $con = OpenCon(); // Sử dụng hàm OpenCon từ db.php

    // Kiểm tra kết nối
    if (!$con) {
        die("Không thể kết nối đến cơ sở dữ liệu.");
    }
    // Sử dụng Prepared Statement để xóa dữ liệu
    $stmt = $con->prepare("DELETE FROM admin_info WHERE admin_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $admin_id);

        if ($stmt->execute()) {
            echo "<script>alert('Xóa quản trị viên thành công!');</script>";
        } else {
            echo "<script>alert('Không thể xóa quản trị viên. Vui lòng thử lại sau!');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Có lỗi xảy ra trong truy vấn SQL.');</script>";
    }
    CloseCon($con);
}
include "sidenav.php";
include "topheader.php";
?>

<!-- Giao diện Quản lý Quản trị viên -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Quản lý nhân viên</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table tablesorter table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên nhân viên</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $con = OpenCon();
                                // Lấy danh sách quản trị viên
                                $stmt = $con->prepare("SELECT admin_id, admin_name, admin_email, role FROM admin_info");
                                
                                if ($stmt) {
                                    $stmt->execute();
                                    $stmt->bind_result($admin_id, $admin_name, $admin_email, $role);
                                    $counter = 1; // Đếm số thứ tự
                                    
                                    while ($stmt->fetch()) {                                       
                                        echo "<tr>
                                            <td>{$counter}</td>
                                            <td>{$admin_name}</td>
                                            <td>{$admin_email}</td>
                                            <td>{$role}</td>
                                            <td>
                                                <a class='btn btn-success' href='edit_employee.php?admin_id={$admin_id}'>Sửa</a>
                                                <a class='btn btn-danger' href='list_employee.php?admin_id={$admin_id}&action=delete'>Xóa<div class='ripple-container'></div></a>
                                            </td>
                                        </tr>";
                                        $counter++;
                                    }
                                
                                    $stmt->close();
                                } else {
                                    echo "<tr><td colspan='5'>Không thể lấy danh sách quản trị viên. Vui lòng thử lại sau.</td></tr>";
                                }
                                
                                CloseCon($con);
                                ?>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
