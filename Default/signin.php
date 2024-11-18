<?php
  session_start();
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | TWP Computer Shop</title>

  <!-- Google Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../Assets/css/bootstrap.min.css">

  <!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../Assets/css/all.min.css">

  <link rel="stylesheet" href="./css/login.css">
  <link rel="stylesheet" href="./css/general.css">

  <link rel="icon" type="image/png" sizes="32x32" href="../Assets/img/logo.png">

</head>
<body>
  <div class="login-container">
    <!-- Login Form -->
    <div class="login-form">
      <h2 class="mb-4">Đăng nhập</h2>
      <form>
        <div class="mb-3">
          <label for="email" class="label-input">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Email của bạn" required>
        </div>
        <div class="mb-4">
          <label for="password" class="label-input">Mật khẩu</label>
          <input type="password" id="password" class="form-control" placeholder="*************" required>
        </div>
        <input type="hidden" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        <div class="login-links">
          <a href="register.html">Đăng ký</a>
          <a href="index.php">Bỏ qua đăng nhập</a>
        </div>
        <div class="alert alert-danger mt-4" id="error" style="display: none;">
          Please register before login..!
        </div>
      </form>
    </div>

    <!-- Background Image -->
    <div class="bg-image">
      <div class="bg-overlay"></div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="../Assets/js/bootstrap.bundle.min.js"></script>

  <script>
    document.querySelector('form').addEventListener('submit', async function (event) {
      event.preventDefault(); 

      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const csrfToken = document.getElementById('csrf_token').value;
      const errorElement = document.getElementById('error');

      if (!email || !password) {
        errorElement.textContent = "Email and password are required.";
        errorElement.style.display = 'block';
        return;
      }

      try {
        const response = await fetch('/TWPComputerShop/Default/Control/login.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ email, password, csrf_token: csrfToken })
        });

        const result = await response.json();

        if (result.success) {
          window.location.href = './index.php';
        } else {
          errorElement.textContent = result.message || "Invalid email or password.";
          errorElement.style.display = 'block';
        }
      } catch (error) {
        errorElement.textContent = "An error occurred. Please try again.";
        errorElement.style.display = 'block';
        console.error(error);
      }
    });
  </script>

</body>
</html>
