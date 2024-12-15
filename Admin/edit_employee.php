<?php
session_start();
include "../Database/db_connection.php";

// Lấy thông tin admin_id
$admin_id = isset($_REQUEST['admin_id']) ? intval($_REQUEST['admin_id']) : 0;

if ($admin_id <= 0) {
    die("ID quản trị viên không hợp lệ.");
}

// Xử lý khi người dùng nhấn nút "Cập nhật"
if (isset($_POST['btn_save'])) {
    $admin_name = trim($_POST['admin_name']);
    $admin_email = trim($_POST['admin_email']);
    $role = trim($_POST['role']);

    $con = OpenCon();
    // Chuẩn bị câu lệnh an toàn
    $query = "UPDATE admin_info SET admin_name = ?, admin_email = ?, role = ? WHERE admin_id = ?";
    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssi", $admin_name, $admin_email, $role, $admin_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: list_employee.php");
            exit();
        } else {
            echo "Có lỗi xảy ra khi cập nhật thông tin: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        die("Chuẩn bị truy vấn thất bại: " . mysqli_error($con));
    }
    CloseCon($con);
}

$con = OpenCon();
// Lấy thông tin quản trị viên để hiển thị trên form
$query = "SELECT admin_name, admin_email, role FROM admin_info WHERE admin_id = ?";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $admin_name, $admin_email,  $role);
    if (!mysqli_stmt_fetch($stmt)) {
        die("Không tìm thấy quản trị viên.");
    }
    mysqli_stmt_close($stmt);
} else {
    die("Truy vấn thất bại: " . mysqli_error($con));
}
CloseCon($con);

include "sidenav.php";
include "topheader.php";
?>

<!-- Nội dung giao diện -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h5 class="title">Sửa thông tin Quản trị viên</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên Quản trị viên</label>
                                <input type="text" name="admin_name" class="form-control" value="<?php echo htmlspecialchars($admin_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="admin_email" class="form-control" value="<?php echo htmlspecialchars($admin_email); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Vai trò</label>
                                <input type="text" name="role" class="form-control" value="<?php echo htmlspecialchars($role); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="btn_save" class="btn btn-fill btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
