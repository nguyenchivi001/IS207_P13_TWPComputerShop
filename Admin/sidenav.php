<?php
session_start();

// Kiểm tra quyền truy cập
if (!isset($_SESSION['admin_name'])) {
    $_SESSION['msg'] = "You must log in first";
    header('Location: ../login.php');
    exit;
}

// Đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin_name']);
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TWPComputerShop | Admin</title>

    <!-- Fonts and icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="./css/material-dashboard.css">
    <link rel="stylesheet" href="./demo/demo.css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="../Assets/img/logo.png">
    <link rel="icon" type="image/png" href="../Assets/img/logo.png">
</head>

<body class="dark-edition">
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-color="purple" data-background-color="black" data-image="../assets/img/sidebar-2.jpg">
            <div class="logo">
                <a href="index.php" class="simple-text logo-normal">
                    <img src="./assets/img/capture.png" alt="Logo" style="width: 150px;">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">
                            <i class="fa-solid fa-house"></i>
                            <p>Trang chủ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./addmembers.html">
                            <i class="fa-solid fa-user-plus"></i>
                            <p>Thêm thành viên</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="managemembers.html">
                            <i class="fa-solid fa-user"></i>
                            <p>Danh sách thành viên</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_product.html">
                            <i class="fa-solid fa-plus"></i>
                            <p>Thêm sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products_list.html">
                            <i class="fa-solid fa-list"></i>
                            <p>Danh sách sản phẩm</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.html">
                            <i class="fa-solid fa-gear"></i>
                            <p>Cài đặt</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="saleofday.html">
                            <i class="fa-solid fa-receipt"></i>
                            <p>Hóa đơn</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
