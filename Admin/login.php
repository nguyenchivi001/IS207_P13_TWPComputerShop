<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../Assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/login_admin.css">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center vh-100">
        <div class="login-card p-4 shadow rounded">
            <div class="logo text-center mb-4 rounded">
                <img src="../Assets/img/logo.png" alt="Logo" class="mb-2">
                <h1>Admin | TWP Computer Shop</h1>
            </div>
            <h2 class="text-center">WELCOME ADMIN</h2>
            <p class="text-center mb-4">Vui lòng đăng nhập.</p>
            <form id="admin-login-form">
                <div class="mb-3">
                    <input type="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <input type="hidden" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                <button type="button" class="btn btn-secondary w-100" onclick="window.location.href='../Default/index.php'">Back to Home</button>
                <div class="alert alert-danger mt-3" id="error" style="display: none;"></div>
            </form>
        </div>
    </div>

    <script src="../Assets/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('admin-login-form').addEventListener('submit', async function (event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const csrfToken = document.getElementById('csrf_token').value;
            const errorElement = document.getElementById('error');

            if (!email || !password) {
                errorElement.textContent = "Vui lòng điền đẩy đủ thông tin";
                errorElement.style.display = 'block';
                return;
            }

            try {
                const response = await fetch('./Control/admin_login_control.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password, csrf_token: csrfToken })
                });

                const result = await response.json();

                if (result.success) {
                    console.log("success");
                    window.location.href = './index.php';
                } else {
                    errorElement.textContent = result.message || "Tên đăng nhập hoặc mật khẩu không hợp lệ";
                    errorElement.style.display = 'block';
                }
            } catch (error) {
                errorElement.textContent = "Có lỗi xảy ra, vui lòng thử lại.";
                errorElement.style.display = 'block';
                console.error(error);
            }
        });
    </script>
</body>
</html>
