<?php
session_start();
include "../Database/db_connection.php";

// Lấy thông tin user_id
$user_id = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;

if ($user_id <= 0) {
    die("ID người dùng không hợp lệ.");
}

// Xử lý khi người dùng nhấn nút "Cập nhật"
if (isset($_POST['btn_save'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
$con=OpenCon();
    // Chuẩn bị câu lệnh an toàn
    $query = "UPDATE user_info SET first_name = ?, last_name = ?, email = ?, password = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssi", $first_name, $last_name, $email, $user_password, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: managemembers.php");
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
$con=OpenCon();
// Lấy thông tin người dùng để hiển thị trên form
$query = "SELECT first_name, last_name, email, password FROM user_info WHERE user_id = ?";
$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $first_name, $last_name, $email, $user_password);
    if (!mysqli_stmt_fetch($stmt)) {
        die("Không tìm thấy người dùng.");
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
                    <h5 class="title">Sửa thành viên</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Họ</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="text" name="password" class="form-control" value="<?php echo htmlspecialchars($user_password); ?>" required>
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

