<?php
session_start();
include "../Database/db_connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TWP Computer</title>

  <!-- Google Fonts-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../Assets/css/bootstrap.min.css">

  <!-- Font Awesome Icon -->
	<link rel="stylesheet" href="../Assets/css/all.min.css">

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/general.css">
  <link rel="stylesheet" href="css/cart.css">
  <link rel="stylesheet" href="css/checkout.css">
  <link rel="stylesheet" href="css/wishlist.css">
  <link rel="stylesheet" href="css/user_information.css">

  <link rel="icon" type="image/png" sizes="32x32" href="../Assets/img/logo.png">
</head>
<body>
  <!-- HEADER -->
  <header>
    <!-- TOP HEADER -->
    <div class="top-header" style="border-bottom: 1px solid #fff;">
      <div class="top-header-container">
        <ul class="top-header-links top-header-left">
          <li><a href="#"><i class="fas fa-phone"></i> 0123456789</a></li>
          <li><a href="#"><i class="fas fa-envelope"></i> twpcomputer@gmail.com</a></li>
          <li><a href="#"><i class="fas fa-map-marker-alt"></i> TP. Hồ Chí Minh</a></li>
        </ul>
        <ul class="top-header-links top-header-right">
          <?php 
            if(isset($_SESSION["uid"])) {
              $con = OpenCon();
              if($con) {
                $stmt = $con->prepare("SELECT first_name FROM user_info WHERE user_id = ?");
                $stmt->bind_param("i", $_SESSION["uid"]);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                  echo '
                  <div class="dropdownmenu">
                    <a href="#" class="dropdownmenu" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-user"></i> Hi ' . htmlspecialchars($row["first_name"]) . '
                    </a>
                    <div class="dropdownmenu-content">
                        <li><a href="user_information.php"><i class="fa-solid fa-circle-user"></i> Thông tin cá nhân</a></li>
                        <li><a href="#"><i class="fas fa-user-shield"></i> Đơn đặt hàng</a></li>
                        <li><a href="./Control/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a></li>
                    </div>
                  </div>
                  ';
                }
                $stmt->close();
              }
              else {
                echo "Not connection to database!";
              }
            }
            else {
              echo '
              <div class="dropdownmenu">
                <a href="#" class="dropdownmenu" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-user"></i> Tài khoản
                </a>
                <div class="dropdownmenu-content">
                    <li><a href="../Admin/login.php"><i class="fas fa-user-shield"></i> Quản trị</a></li>
                    <li><a href="./signin.php"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a></li>
                    <li><a href="./signup.php"><i class="fas fa-user-plus"></i> Đăng ký</a></li>
                </div>
              </div>
              ';
            }
          ?>
        </ul>
      </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div class="main-header">
      <div class="main-header-container">
        <!-- LEFT SECTION -->
        <div class="main-header-left-section"> 
          <a href="index.php" class="logo d-flex align-items-center"> 
            <img src="../Assets/img/logo.png" class="img-fluid">
            <div class="name">
              <span class="main-name">
                THE WOLF PACK
              </span>
              <span class="sub-name">
                Computer Shop
              </span>
            </div>
          </a>
        </div>
        <!-- /LEFT SECTION -->

        <!-- MIDDLE SECTION-->
        <div class="main-header-middle-section">
          <form method="GET" action="products.php" class="search">
              <input class="search-bar" id="search-bar" name="q" type="text" placeholder="Nhập từ khoá">
              <button type="submit" id="search_btn" class="search-btn"><i class="fas fa-magnifying-glass"></i></button>
          </form>
        </div>
        <!-- /MIDDLE SECTION -->
        
        <!-- RIGHT SECTION -->
        <div class="main-header-right-section">
          <div class="wish-list right-section-items">
              <a href="wishlist.php">
                  <i class="far fa-heart"></i>
                  <span>Yêu thích</span>
                  <div id="wishlist-badge" class="qty">0</div>
              </a>
          </div>
          
          <!-- CART-->
          <div class="dropdown right-section-items">
              <a class="dropdown-toggle" data-bs-toggle="dropdown">
                  <i class="fas fa-shopping-cart"></i>
                  <span>Giỏ hàng</span>
                  <div id="cart-badge" class="qty">0</div>
              </a>
              <div class="dropdown-menu cart-dropdown">
                  <div class="cart-list" id="cart_product"></div>
                  <div class="cart-button">
                      <a href="cart.php">
                          <i class="fas fa-edit"></i> Thay đổi giỏ hàng
                      </a>
                  </div>
              </div>
          </div>
          <!-- /CART-->

        </div>
        <!-- /RIGHT SECTION -->
      </div>
    </div>
    <!-- /MAIN HEAER -->

    <!-- BOTTOM HEADER-->
    <div class="bottom-header">
      <nav class='navigation'>
        <div id="get_category_home">
          <div class="responsive-nav">
            <ul class="main-nav">
              <li class="category" cid="0"><a href="index.php">Trang chủ</a></li>
              <li class="category" cid="1"><a href="products.php?cid=1">Laptop Gaming</a></li>
              <li class="category" cid="2"><a href="products.php?cid=2">Laptop Học tập, Văn phòng</a></li>
              <li class="category" cid="3"><a href="products.php?cid=3">Laptop Đồ họa</a></li>
              <li class="category" cid="4"><a href="products.php?cid=4">Laptop Mỏng nhẹ</a></li>
            </ul>
          </div>
        </div>
      </nav>
  
      <!-- MENU -->
      <div class="menu">
        <a href="#">
          <i class="fa fa-bars"></i>
          <span>Menu</span>
        </a>
      </div>
      <!-- /MENU -->
    </div>
    <!-- /BOTTOM HEADER-->

  </header>
  <!-- /HEADER -->

  <script src="../Assets/js/bootstrap.bundle.min.js"></script>
  <script src="./js/header.js"></script>
</body>
</html>

