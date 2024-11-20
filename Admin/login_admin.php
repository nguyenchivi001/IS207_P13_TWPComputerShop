<?php
session_start();
include "./server/server.php"; // Kết nối đến cơ sở dữ liệu

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['admin_username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $errors[] = "Username và Password không được để trống.";
    } else {
        // Truy vấn dữ liệu từ bảng admin_info
        $query = "SELECT * FROM admin_info WHERE admin_email = ?";
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username); // Gán tham số email
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                $admin = mysqli_fetch_assoc($result);

                // Kiểm tra mật khẩu
                if ($password === $admin['admin_password']) { // Nếu mật khẩu chưa mã hóa
                    // Lưu thông tin vào session
                    $_SESSION['admin_name'] = $admin['admin_name'];
                    $_SESSION['admin_email'] = $admin['admin_email'];

                    // Chuyển hướng đến sidenav.php
                    header("Location: sidenav.php");
                    exit;
                } else {
                    $errors[] = "Sai mật khẩu.";
                }
            } else {
                $errors[] = "Email không tồn tại.";
            }
        } else {
            $errors[] = "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($db);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/Admin/css/login_admin.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="../Assets/img/logo.png" alt="TWP">
            <h1>THE WOLF PACK</h1>
        </div>
        <div class="login-form">
            <h2>WELCOME ADMIN</h2>
            <p>Please login to Admin Dashboard.</p>
            <!-- Hiển thị lỗi từ PHP -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h4 id="e_msg">
                        <?php foreach ($errors as $error): ?>
                            <?= htmlspecialchars($error) ?><br>
                        <?php endforeach; ?>
                    </h4>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post">
                <input
                    type="text"
                    name="admin_username"
                    placeholder="Username (Email)"
                    required
                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                    title="Please enter a valid email address"
                >
                <br>
                <input
                    type="password"
                    name="password"
                    placeholder="Password"
                    required
                    minlength="6"
                    title="Password must be at least 6 characters long"
                >
                <button type="submit" name="login">Login</button>
                <!-- Back to Home -->
                <button type="button" class="back-home" onclick="window.location.href='../Default/index.php'">Back to Home</button>
            </form>
        </div>
    </div>

    <!-- JS -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>
