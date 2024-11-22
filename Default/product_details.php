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
  <div class="container mt-5">
    <div class="row">
      <!-- Hiển thị thông tin sản phẩm -->
      <div class="col-md-6">
        <div id="product-main-img" class="mb-3">
          <img src="../../Assets/product_images/<?php echo htmlspecialchars($product['product_image']); ?>"
            class="img-fluid rounded"
            alt="<?php echo htmlspecialchars($product['product_title']); ?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="product-details">
          <h2><?php echo htmlspecialchars($product['product_title']); ?></h2>
          <h3 class="text-danger">
            <?php echo number_format($product['product_price'], 0, '', ','); ?>Đ
            <del class="text-muted">92,849,999Đ</del>
          </h3>
          <p class="text-success">Còn hàng</p>
          <p>
            Laptop thế hệ mới mang đam mê của bạn bắt nhịp với lối sống năng động.
            Dù là đang làm việc hay sử dụng trên giảng đường, vi xử lí Intel Core Tiger Lake thế hệ 11 mới nhất
            và card đồ họa tích hợp Modern series cũng sẽ đáp ứng mọi nhu cầu của bạn.
          </p>
          <div class="mb-3">
            <label class="form-label">Ổ cứng</label>
            <select class="form-select">
              <option>512GB</option>
              <option>1024GB</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Màu sắc</label>
            <select class="form-select">
              <option>Đỏ</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Số lượng</label>
            <input type="number" class="form-control w-25" value="1">
          </div>
          <button class="btn btn-primary btn-lg w-100"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
          <ul class="list-unstyled mt-3">
            <li><a href="#" class="text-secondary"><i class="far fa-heart"></i> Thêm vào danh sách yêu thích</a></li>
            <li><a href="#" class="text-secondary"><i class="fas fa-exchange-alt"></i> So sánh</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SECTION: Sản phẩm cùng phân khúc -->
<!-- <div class="container mt-5">
    <h3 class="text-center">Các sản phẩm cùng phân khúc</h3>
    <div class="row">
        <?php
        // Lấy danh sách sản phẩm cùng phân khúc từ session
        // Giả sử bạn đã lưu các sản phẩm khác cùng phân khúc vào session trong `show_product_details.php`
        if (isset($_SESSION['related_products'])) {
          foreach ($_SESSION['related_products'] as $related) {
            echo '
                <div class="col-md-3">
                    <div class="card">
                        <img src="product_images/' . htmlspecialchars($related['product_image']) . '" 
                             class="card-img-top" 
                             alt="' . htmlspecialchars($related['product_title']) . '">
                        <div class="card-body text-center">
                            <p class="text-muted mb-1">' . htmlspecialchars($related['cat_title']) . '</p>
                            <h5 class="card-title">' . htmlspecialchars($related['product_title']) . '</h5>
                            <p class="text-danger">' . number_format($related['product_price'], 0, '', ',') . 'Đ
                                <del class="text-muted">92,849,999Đ</del>
                            </p>
                            <button class="btn btn-sm btn-primary"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
                ';
          }
        }
        ?>
    </div>
</div> -->

<?php
include "newsletter.html";
include "footer.html";
?>