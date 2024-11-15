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
            <img src="../Assets/img/logo.png" alt="Bailey and Co.">
            <h1>THE WOLF PACK</h1>
        </div>
        <div class="login-form">
            <h2>WELCOME ADMIN</h2>
            <p>Please login to Admin Dashboard.</p>
            <form>
                <input type="text" placeholder="Username" required>
                <input type="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <!-- Add "Back to Home" button here -->
                <button type="button" class="back-home" onclick="window.location.href='header.html'">Back to Home</button>
            </form>
        </div>
    </div>

    <script src="./js/jquery.min.js"></script>
    <script src=""></script>
</body>
</html>

