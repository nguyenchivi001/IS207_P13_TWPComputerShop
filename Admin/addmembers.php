<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
include "../Database/db_connection.php";
include "sidenav.php";
include "topheader.php";

if (isset($_POST['btn_save'])) {
    $admin_name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $admin_password = trim($_POST['admin_password']);
  $role=trim($_POST['role']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!');</script>";
    }
    else {
    
        $hashed_password =md5($admin_password);
$con=OpenCon();
        $stmt = $con->prepare("INSERT INTO admin_info (admin_name, admin_email, admin_password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $admin_name, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('nhân viên mới đã được thêm thành công!');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi thêm nhân viên mới.');</script>";
        }
        
        $stmt->close();
        CloseCon($con);
    }
}
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Thêm nhân viên</h4>
                    <p class="card-category">Thông tin</p>
                </div>
                <div class="card-body">
                    <form action="" method="post" name="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Tên</label>
                                    <input type="text" name="admin_name" id="admin_name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" name="admin_email" id="admin_email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Mật khẩu</label>
                                    <input type="password" id="admin_password" name="admin_password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Role</label>
                                    <input type="text" id="role" name="role" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btn_save" id="btn_save" class="btn btn-primary pull-right">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    include "footer.php";
 ?>
