<?php
session_start();
include "../Database/db_connection.php";

if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['re_password'])) {
    $email = $_SESSION['admin_email'];

    $old_pass = $_POST['old_pass'] ?? '';
    $new_pass = $_POST['new_pass'] ?? '';
    $re_pass = $_POST['re_pass'] ?? '';

    // Kiểm tra mật khẩu mới có khớp
    if ($new_pass !== $re_pass) {
        echo "<script>alert('Mật khẩu mới không trùng khớp');</script>";
        exit();
    }

    // Kiểm tra độ dài mật khẩu
    if (strlen($new_pass) < 8) {
        echo "<script>alert('Mật khẩu mới phải có ít nhất 8 ký tự');</script>";
        exit();
    }
    $con=OpenCon();

    // Lấy mật khẩu hiện tại từ cơ sở dữ liệu
    $stmt = $con->prepare("SELECT admin_password FROM admin_info WHERE admin_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($database_password);
    $stmt->fetch();
    $stmt->close();

    // Xác minh mật khẩu cũ
    if (!password_verify($old_pass, $database_password)) {
        echo "<script>alert('Mật khẩu cũ không chính xác');</script>";
        exit();
    }

    // Băm mật khẩu mới
    $hashed_new_pass = password_hash($new_pass, PASSWORD_BCRYPT);

    // Cập nhật mật khẩu trong cơ sở dữ liệu
    $stmt = $con->prepare("UPDATE admin_info SET admin_password = ? WHERE admin_email = ?");
    $stmt->bind_param("ss", $hashed_new_pass, $email);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật mật khẩu thành công');</script>";
    } else {
        echo "<script>alert('Đã xảy ra lỗi. Vui lòng thử lại');</script>";
    }

    $stmt->close();
    CloseCon($con);
}

include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Sửa thông tin</h4>
                        <p class="card-category">Hoàn thành thông tin của bạn</p>
                    </div>
                    <div class="card-body">
                        <form method="post" action="profile.php">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">
                                            <?php if (isset($_SESSION['admin_name'])) : ?>
                                                <?= htmlspecialchars($_SESSION['admin_name']); ?>
                                            <?php endif; ?>
                                        </label>
                                        <input type="text" class="form-control" disabled="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Nhập mật khẩu cũ</label>
                                        <input type="password" class="form-control" name="old_pass" id="old_pass" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Nhập mật khẩu mới</label>
                                        <input type="password" class="form-control" name="new_pass" id="new_pass" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating">Nhập lại mật khẩu mới</label>
                                        <input type="password" class="form-control" name="re_pass" id="re_pass" required>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary pull-right" type="submit" name="re_password">Cập nhật</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
