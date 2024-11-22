<?php
session_start();
if (!isset($_SESSION['product_details'])) {
  echo "failed";
}

// Lấy thông tin sản phẩm từ session
$product = $_SESSION['product_details'];

include "header.php";
?>

<!-- SECTION -->
<link rel="stylesheet" href="css/product_details.css">
<div class="main">
  <div class="product-page">
    <div class="product-gallery">
      <div class="image-thumbnails">
        <img src="../../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
        <img src="../../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
        <img src="../../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="" onclick="changeImage(this)">
      </div>
      <div class="main-image">
        <img id="mainImage" src="../../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Main product image">
      </div>
    </div>
    <div class="product-info">
      <h2><?php echo htmlspecialchars($product['product_title']); ?></h2>
      <h3 class="text-danger">
        <?php echo number_format($product['product_price'], 0, '', ','); ?>Đ
        <del class="text-muted">92,849,999Đ</del>
      </h3>
      <p class="status">Còn hàng</p>
      <p class="description">
        Laptop thế hệ mới mang đam mê của bạn bắt nhịp với lối sống năng động. Dù là làm việc hay sử dụng trên giảng đường...
      </p>
      <div class="option">
        <label for="storage">Ổ CỨNG:</label>
        <select id="storage" name="storage">
          <option>512GB</option>
          <option>1024GB</option>
        </select>
      </div>
      <div class="option">
        <label for="color">MÀU SẮC:</label>
        <select id="color" name="color">
          <option value="red">Đen</option>
          <option value="red">Xanh</option>
        </select>
      </div>
      <div class="option">
        <label for="quantity">SỐ LƯỢNG:</label>
        <input type="number" class="form-control w-25" id="quantity" name="quantity" value="1" min="1">
      </div>
      <div class="button">
        <div class="add-wishlist">
          <button class="add-to-wishlist">
            <i class="fa-regular fa-heart"></i>
            <span class="tooltip">Thêm vào danh sách ưa thích</span>
          </button>
        </div>
        <div class="add-to-cart">
          <button class="add-to-cart-btn"><i class="fa-solid fa-cart-shopping"></i>Thêm vào giỏ hàng</button>
        </div>
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
  <div>
    
  </div>
  <script src="./Js/product_details.js"></script>
</div>

<?php
include "newsletter.html";
include "footer.html";
?>