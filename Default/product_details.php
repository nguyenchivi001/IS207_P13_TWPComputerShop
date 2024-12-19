<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (!isset($_SESSION['product_details'])) {
  echo "failed";
}
// Lấy thông tin sản phẩm từ session
$product = $_SESSION['product_details'];

include "header.php";
?>

<!-- SECTION -->
<link rel="stylesheet" href="css/product_details.css">
<link rel="stylesheet" href="css/body.css">
<div class="main">
  <div class="product-page">
    <div class="product-gallery">
      <div class="image-thumbnails">
        <img src="../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
        <img src="../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
        <img src="../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
      </div>
      <div class="main-image">
        <img id="mainImage" src="../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Main product image">
      </div>
    </div>
    <div class="product-info">
      <h2><?php echo htmlspecialchars($product['product_title']); ?></h2>
      <h3 class="text-danger">
        <?php echo number_format($product['product_price'], 0, '', ','); ?>Đ
        <del class="text-muted"><?php echo number_format($product['product_price'] * 1.3, 0, '', ','); ?>Đ</del>
      </h3>
      <p class="status">Còn hàng</p>
      <p class="description">
        Laptop thế hệ mới mang đam mê của bạn bắt nhịp với lối sống năng động. Dù là làm việc hay sử dụng trên giảng đường...
      </p>
      <div class="product-options">
        <div class="option">
          <label for="storage">Ổ Cứng:</label>
          <select id="storage" name="storage">
            <option>512GB</option>
            <option>1024GB</option>
          </select>
        </div>
        <div class="option">
          <label for="color">Màu Sắc:</label>
          <select id="color" name="color">
            <option value="black">Đen</option>
            <option value="blue">Xanh</option>
          </select>
        </div>
        <div class="option">
          <label for="quantity">Số Lượng:</label>
          <input type="number" id="quantity" name="quantity" value="1" min="1">
        </div>
      </div>

      <div class="button-box mt-3">
        <?php
        echo '
          <div id="add_Wl" class="add-wishlist" 
            pid="' . intval($product['product_id']) . '"
            token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
          >
            <button class="add-wishlist-btn"><i class="fa-regular fa-heart"></i>Thêm vào yêu thích</button>
          </div>
          <div id="add-to-cart" class="add-to-cart" 
            pid="' . intval($product['product_id']) . '"
            token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
          >
            <button class="add-to-cart-btn"><i class="fa-solid fa-cart-shopping"></i>Thêm vào giỏ hàng</button>
          </div>  
        ';
        ?>
      </div>

      <div class="additional-info">
        <p>Chia sẻ:
          <a href="#">Facebook</a> |
          <a href="#">Twitter</a> |
          <a href="#">Email</a>
        </p>
      </div>
    </div>
  </div>

  <div class="product-details">
    <h3 class="my-5">Thông số kỹ thuật</h3>
    <?php
      $parts = explode("/", $product['product_desc']);

      $cpu = $parts[0]; 
      $ram = $parts[1]; 
      $ssd = $parts[2]; 
      $card = $parts[3];
      echo '
          <table border="1" cellpadding="10" cellspacing="0" style="margin: 0 auto;">
          <thead>
            <tr>
              <th>Thông số</th>
              <th>Chi tiết</th>
            </tr>
          </thead>
            <tbody>
              <tr>
                <td><strong>CPU</strong></td>
                <td>Intel Core ' . htmlspecialchars($cpu, ENT_QUOTES) . ' (12 nhân, 8 luồng, tốc độ cơ bản 3.3 GHz, turbo tối đa 4.4 GHz)</td>
              </tr>
              <tr>
                <td><strong>RAM</strong></td>
                <td>' . htmlspecialchars($ram, ENT_QUOTES) . '  DDR4</td>
              </tr>
              <tr>
                <td><strong>Ổ cứng</strong></td>
                <td>' . htmlspecialchars($ssd, ENT_QUOTES) . '  M.2 NVMe</td>
              </tr>
              <tr>
                <td><strong>Màn hình</strong></td>
                <td>14.0 inch Full HD (1920 x 1080), IPS, độ sáng cao</td>
              </tr>
              <tr>
                <td><strong>Hệ điều hành</strong></td>
                <td>Windows 11 (64-bit)</td>
              </tr>
              <tr>
                <td><strong>Card đồ họa</strong></td>
                <td>' . htmlspecialchars($card, ENT_QUOTES) . '</td>
              </tr>
              <tr>
                <td><strong>Cổng kết nối</strong></td>
                <td>2 x USB 3.2 Gen 1, 1 x USB Type-C, 1 x HDMI 2.0, Jack tai nghe 3.5mm</td>
              </tr>
              <tr>
                <td><strong>Kết nối mạng</strong></td>
                <td>Wi-Fi 6 (802.11ax), Bluetooth 5.1</td>
              </tr>
              <tr>
                <td><strong>Pin</strong></td>
                <td>Pin Li-ion 3 cell, khoảng 8-10 giờ sử dụng</td>
              </tr>
              <tr>
                <td><strong>Kích thước và trọng lượng</strong></td>
                <td>32.5 x 22.5 x 1.8 cm, trọng lượng 1.4 kg</td>
              </tr>
            </tbody>
          </table>
      ';
    ?>
  </div>

  <div class="container-fluid" style="width:95%;">
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="section-title">
							<h3 class="title" style="color: #000;">Sản phẩm tương tự</h3>
						</div>
					</div>
          <div class="row shadow rounded" style="background-color: #EAF3FE;">
          <?php
          $con = OpenCon();
          $sql = "SELECT * FROM products AS P 
                  JOIN categories AS C ON P.product_cat = C.cat_id
                  WHERE C.cat_id = ?";
          $stmt = $con->prepare($sql);
          $stmt->bind_param("i", $product['product_cat']);
          $stmt->execute();
          $result = $stmt->get_result();
          $count = 0;
          while ($row = $result->fetch_assoc())
          {
            if($count > 3) break;
            if($row['product_id'] == $product['product_id']) continue;
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
                    <button class="add-to-cart-btn"
                      pid="' . intval($row['product_id']) . '" 
                      id="product"
                      token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                    >
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
  <script src="./js/product_details.js"></script>
</div>

<script src="./js/action.js"></script>

<script>
  const add_To_Cart = document.getElementById("add-to-cart");
  add_To_Cart.addEventListener('click', () => {
    const productId = add_To_Cart.getAttribute('pid');
    const csrfToken = add_To_Cart.getAttribute('token');
    const quantity = document.getElementById("quantity").value;
    addToCart(productId, quantity, csrfToken);
  });

  const add_To_Wishlist = document.getElementById("add_Wl");
  add_Wl.addEventListener('click', () => {
    const productId = add_Wl.getAttribute('pid');
    const csrfToken = add_Wl.getAttribute('token');
    addToWishlist(productId, csrfToken);
  });

  document.querySelectorAll('a.product').forEach(function(product) {
    product.addEventListener('click', function(event) {
        event.preventDefault();

        const productId = this.getAttribute('pid');
        const csrfToken = this.getAttribute('token');
        ShowProductDetails(productId, csrfToken);
    });
  });
</script>


<?php
include "newsletter.html";
include "footer.html";
?>