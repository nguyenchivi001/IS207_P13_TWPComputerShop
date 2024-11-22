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
  <title>Register | TWP Computer Shop</title>

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
    <!-- Background Image -->
    <div class="bg-image">
        <div class="bg-overlay"></div>
      </div>
    <!-- Login Form -->
    <div class="register-form">
      <h2 class="mb-4">Đăng ký</h2>
      <form onsubmit="return false">
        <div class="mb-3">
            <label for="lastname" class="label-input">Họ</label>
            <input type="text" id="lastname" class="form-control" placeholder="Họ" required>
        </div>
        <div class="mb-3">
            <label for="firstname" class="label-input">Tên</label>
            <input type="text" id="firstname" class="form-control" placeholder="Tên" required>
        </div>
        <div class="mb-3">
          <label for="email" class="label-input">Email</label>
          <input type="email" id="email" class="form-control" placeholder="Email của bạn" required>
        </div>
        <div class="mb-3">
          <label for="phone" class="label-input">Số điện thoại</label>
          <input type="phone" id="phone" class="form-control" placeholder="039 xxx xxx" required>
        </div>
        <div class="mb-3">
          <label for="password" class="label-input">Mật khẩu</label>
          <input type="password" id="password" class="form-control" placeholder="*************" required>
        </div>
        <div class="mb-3">
          <label for="password-confirm" class="label-input">Xác nhận mật khẩu</label>
          <input type="password" id="password-confirm" class="form-control" placeholder="*************" required>
        </div>
        <div class="mb-3">
            <label for="address1" class="label-input">Địa chỉ</label>
            <input type="text" id="address1" class="form-control" placeholder="Địa chỉ" required>
        </div>
        <div class="mb-4">
            <label for="address2" class="label-input">Thành phố</label>
            <input type="text" id="address2" class="form-control" placeholder="Thành phố" required>
        </div>
        <div class="form-check mb-4">
          <input class="form-check-input" type="checkbox" id="terms" required>
          <label class="form-check-label" for="terms">Đồng ý với các <a href="#">điều khoản</a></label>
        </div>
        <input type="hidden" id="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
        <div class="login-links">
          <a href="signin.php">Đăng nhập</a>
          <a href="index.php">Bỏ qua đăng ký</a>
        </div>
        <div class="alert alert-danger mt-4" id="error" style="display: none;">
          Please register before login..!
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="../Assets/js/bootstrap.bundle.min.js"></script>

  <script>
    document.querySelector('form').addEventListener('submit', async function (event) {
      event.preventDefault(); 

      const fname = document.getElementById('firstname').value;
      const lname = document.getElementById('lastname').value;
      const email = document.getElementById('email').value;
      const phone = document.getElementById('phone').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('password-confirm').value;
      const address1 = document.getElementById('address1').value;
      const address2 = document.getElementById('address2').value;
      const csrfToken = document.getElementById('csrf_token').value;
      const errorElement = document.getElementById('error');

      if (!fname || !lname || !email || !password || !confirmPassword || !phone || !address1 || !address2) {
        errorElement.textContent = "Vui lòng điền đầy đủ thông tin.";
        errorElement.style.display = 'block';
        return;
      }

      if (password !== confirmPassword) {
        errorElement.textContent = "Mật khẩu không giống nhau.";
        errorElement.style.display = 'block';
        return;
      }

      try {
        const response = await fetch('./Control/signup_control.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ fname, lname, email, phone, password, confirmPassword, address1, address2, csrf_token: csrfToken })
        });

        const result = await response.json();
        console.log(result)

        if (result.success) {
          window.location.href = './signin.php';
        } else {
          errorElement.textContent = result.message || "Có lỗi xảy ra. Vui lòng thử lại";
          errorElement.style.display = 'block';
        }
      } catch (error) {
        errorElement.textContent = "Có lỗi xảy ra. Vui lòng thử lại";
        errorElement.style.display = 'block';
        console.error(error);
      }
    });
  </script>
</body>
</html>
