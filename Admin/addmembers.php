<?php
session_start();
include("db.php");
include "sidenav.php";
//include "topheader.php";

if (isset($_POST['btn_save'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
    $mobile = trim($_POST['phone']);
    $address1 = trim($_POST['city']);
    $address2 = trim($_POST['country']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email không hợp lệ!');</script>";
    } elseif (!ctype_digit($mobile)) {
        echo "<script>alert('Số điện thoại chỉ được chứa số!');</script>";
    } else {
    
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $stmt = $con->prepare("INSERT INTO user_info (first_name, last_name, email, password, mobile, address1, address2) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $first_name, $last_name, $email, $hashed_password, $mobile, $address1, $address2);

        if ($stmt->execute()) {
            echo "<script>alert('Thành viên mới đã được thêm thành công!');</script>";
        } else {
            echo "<script>alert('Có lỗi xảy ra khi thêm thành viên mới.');</script>";
        }

        $stmt->close();
    }
    mysqli_close($con);
}
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Thêm thành viên</h4>
                    <p class="card-category">Thông tin</p>
                </div>
                <div class="card-body">
                    <form action="" method="post" name="form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Họ</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Tên</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Mật khẩu</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">SĐT</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Địa chỉ</label>
                                    <input type="text" name="country" id="country" class="form-control" required>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Thành phố</label>
                                    <input type="text" name="city" id="city" class="form-control" required>
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

