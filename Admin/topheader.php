<?php
if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    // Hủy session và đăng xuất
    session_unset();   // Hủy tất cả biến session
    session_destroy(); // Hủy session
    
    // Sau khi logout, chuyển hướng người dùng đến trang login
    header("Location: login.php");
    exit();  // Dừng script sau khi header đã chuyển hướng
}
?>
<div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top" id="navigation-example">
        <div class="container">
            <div class="navbar-wrapper">
                    <a class="navbar-brand" style="color: #fff;">Welcome: <span style="font-weight:bold; color:#fff;"><?php  if (isset($_SESSION['admin_name'])) : ?><?php echo $_SESSION['admin_name']; ?>
         <?php endif ?></span></a>
            
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a href="?logout=1"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
