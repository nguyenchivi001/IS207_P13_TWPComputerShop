<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!-- Custom Stylesheet -->
<link rel="stylesheet" href="css/body.css">

<div class="main">
  <div class="container-fluid main-raised" style="width:95%;  background-color: #EAF3FE;">
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="../Assets/img/banner1.jpg" alt="Los Angeles" style="width:100%;">
        </div>
        <div class="carousel-item">
          <img src="../Assets/img/banner2.jpg" style="width:100%;">
        </div>
        <div class="carousel-item">
          <img src="../Assets/img/banner3.jpg" alt="New York" style="width:100%;">
        </div>
      </div>
			<!-- Carousel Controls -->
			<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
    </div>

		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3 col-6">
					<a href="products.php?cid=1" class="text-decoration-none">
						<div class="catalog main-raised">
							<div class="catalog-img">
								<img src="../Assets/img/alienware3.png" class="img-fluid" alt="Laptop Gaming">
							</div>
							<div class="catalog-body text-start">
								<h4>Laptop<br>Gaming</h4>
								<a href="products.php?cid=1" class="cta-btn">
									Mua ngay 
								</a>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-3 col-6">
					<a href="products.php?cid=2" class="text-decoration-none">
						<div class="catalog main-raised">
							<div class="catalog-img">
								<img src="../Assets/img/msi5.png" class="img-fluid" alt="Laptop Văn Phòng">
							</div>
							<div class="catalog-body text-start">
								<h4>Laptop<br>Văn Phòng</h4>
								<a href="products.php?cid=2" class="cta-btn">
									Mua ngay
								</a>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-3 col-6">
					<a href="products.php?cid=3" class="text-decoration-none">
						<div class="catalog main-raised">
							<div class="catalog-img">
								<img src="../Assets/img/apple1.png" class="img-fluid" alt="Laptop Đồ Họa">
							</div>
							<div class="catalog-body text-start">
								<h4>Laptop<br>Đồ Họa</h4>
								<a href="products.php?cid=3" class="cta-btn">
									Mua ngay
								</a>
							</div>
						</div>
					</a>
				</div>

				<div class="col-md-3 col-6">
					<a href="products.php?cid=4" class="text-decoration-none">
						<div class="catalog main-raised">
							<div class="catalog-img">
								<img src="../Assets/img/lg6.png" class="img-fluid" alt="Laptop Mỏng nhẹ">
							</div>
							<div class="catalog-body text-start">
								<h4>Laptop<br>Mỏng nhẹ</h4>
								<a href="products.php?cid=4" class="cta-btn">
									Mua ngay
								</a>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
  </div>

	<div class="container-fluid main-raised" style="width:95%;  background-color: #fff;">
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h3 class="title">Sản phẩm mới nhất</h3>
						</div>
					</div>

          <?php
          $con = OpenCon();
          
          $sql = "SELECT * FROM products AS P 
                  JOIN categories AS C ON P.product_cat = C.cat_id
                  WHERE C.cat_id = 1 ";
          $stmt = $con->prepare($sql);
          $stmt->execute();
          $result = $stmt->get_result();
          $count = 0;
          while ($row = $result->fetch_assoc())
          {
            if($count > 3) break;
            echo 
            '<div class="col-md-3 col-6">
              <div class="product main-raised">
                <a class="product" pid="' . intval($row['product_id']) . '" 
                  token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                >
                  <div class="product-img">
                    <img src="../Assets/product_images/' . htmlspecialchars($row['product_image'], ENT_QUOTES) . '" alt="">
                    <div class="product-label">
                      <span class="sale">-15%</span>
                      <span class="new">NEW</span>
                    </div>
                  </div>
                </a>
                <div class="product-body">
                    <p class="product-category">Laptop Gaming</p>
                    <h3 class="product-name header-cart-item-name">
                        <h5 class="product-name">' 
                          . htmlspecialchars($row['product_title'], ENT_QUOTES) . 
                        '</h5>
                    </h3>
                    <h4 class="product-price header-cart-item-info">
                        ' . number_format($row['product_price'], 0, '', ',') . 'Đ
                        <del class="product-old-price">' . number_format($row['product_price']*1.15, 0, '', ',') . 'Đ</del>
                    </h4>
                    <div class="product-rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="product-btns">
                        <button class="add-to-wishlist">
                          <i class="fa-regular fa-heart"></i>
                          <span class="tooltip">Thêm vào danh sách ưa thích</span>
                        </button>
                        <button class="add-to-compare">
                          <i class="fa-solid fa-arrow-right-arrow-left"></i>
                          <span class="tooltip">So sánh</span>
                        </button>
                        <button class="quick-view">
                          <i class="fa-solid fa-eye"></i>
                          <span class="tooltip">Xem nhanh</span>
                        </button>
                    </div>
                </div>
                <div class="add-to-cart">
                    <button class="add-to-cart-btn">
                      <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng
                    </button>
                </div>
              </div>
            </div>';
          $count++;
          }
          ?>
				</div>
			</div>
		</div>

    <!-- HOT DEAL SECTION -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="hot-deal">
            <ul class="hot-deal-countdown">
              <li>
                  <div>
                      <h3>02</h3>
                      <span>Ngày</span>
                  </div>
              </li>
              <li>
                  <div>
                      <h3>10</h3>
                      <span>Giờ</span>
                  </div>
              </li>
              <li>
                  <div>
                      <h3>34</h3>
                      <span>Phút</span>
                  </div>
              </li>
              <li>
                  <div>
                      <h3>60</h3>
                      <span>Giây</span>
                  </div>
              </li>
            </ul>
            <h2 class="text-uppercase">Giảm giá sâu trong tuần</h2>
            <p>Sản phẩm mới giảm giá 20% </p>
            <a class="primary-btn cta-btn" href="#">Nhấn vào đây</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /HOT DEAL SECTION -->
	</div>

  <div class="container-fluid" style="width:95%;">
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h3 class="title" style="color: #fff;">Sản phẩm bán chạy</h3>
						</div>
					</div>
          <div class="row shadow rounded" style="background-color: #EAF3FE;">
          <?php
          $con = OpenCon();
          
          $sql = "SELECT * FROM products AS P 
                  JOIN categories AS C ON P.product_cat = C.cat_id
                  WHERE C.cat_id = 4 ";
          $stmt = $con->prepare($sql);
          $stmt->execute();
          $result = $stmt->get_result();
          $count = 0;
          while ($row = $result->fetch_assoc())
          {
            if($count > 3) break;
            echo 
            '<div class="col-md-3 col-6">
              <div class="product main-raised">
                <a class="product" pid="' . intval($row['product_id']) . '" 
                  token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                >
                  <div class="product-img">
                    <img src="../Assets/product_images/' . htmlspecialchars($row['product_image'], ENT_QUOTES) . '" alt="">
                    <div class="product-label">
                      <span class="sale">-30%</span>
                      <span class="new">NEW</span>
                    </div>
                  </div>
                </a>
                <div class="product-body">
                    <p class="product-category">Laptop Gaming</p>
                    <h3 class="product-name header-cart-item-name">
                        <h5 class="product-name">' 
                          . htmlspecialchars($row['product_title'], ENT_QUOTES) . 
                        '</h5>
                    </h3>
                    <h4 class="product-price header-cart-item-info">
                        ' . number_format($row['product_price'], 0, '', ',') . 'Đ
                        <del class="product-old-price">' . number_format($row['product_price']*1.4, 0, '', ',') . 'Đ</del>
                    </h4>
                    <div class="product-rating">
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                      <i class="fa-solid fa-star"></i>
                    </div>
                    <div class="product-btns">
                        <button class="add-to-wishlist">
                          <i class="fa-regular fa-heart"></i>
                          <span class="tooltip">Thêm vào danh sách ưa thích</span>
                        </button>
                        <button class="add-to-compare">
                          <i class="fa-solid fa-arrow-right-arrow-left"></i>
                          <span class="tooltip">So sánh</span>
                        </button>
                        <button class="quick-view">
                          <i class="fa-solid fa-eye"></i>
                          <span class="tooltip">Xem nhanh</span>
                        </button>
                    </div>
                </div>
                <div class="add-to-cart">
                    <button class="add-to-cart-btn">
                      <i class="fa-solid fa-cart-shopping"></i> Thêm vào giỏ hàng
                    </button>
                </div>
              </div>
            </div>';
          $count++;
          }
          ?>
          </div>
				</div>
			</div>
		</div>
	</div>
</div>
  