<?php
include "header.php";
?>

<link rel="stylesheet" href="css/products.css">
<div class="section main main-raised">
  <div class="container">
    <div class="row">
      <?php
        // Kết nối tới cơ sở dữ liệu
        $con = OpenCon();

        // Lấy product_id từ query string và kiểm tra đầu vào
        if (isset($_GET['cid'])) {
          $cid = $_GET['cid'];
        }

        // Chuẩn bị câu truy vấn an toàn
        $sql = "SELECT * FROM products AS P, categories AS C WHERE P.product_cat = C.cat_id AND C.cat_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $cid);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col-lg-5 order-lg-2">
              <div id="product-main-img" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="product_images/' . htmlspecialchars($row['product_image'], ENT_QUOTES) . '" class="d-block w-100" alt="">
                  </div>
                  <div class="carousel-item">
                    <img src="product_images/' . htmlspecialchars($row['product_image'], ENT_QUOTES) . '" class="d-block w-100" alt="">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#product-main-img" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#product-main-img" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
            <div class="col-lg-5 order-lg-1">
              <div class="product-details">
                <h2 class="product-name">' . htmlspecialchars($row['product_title'], ENT_QUOTES) . '</h2>
                <h3 class="product-price">' . number_format($row['product_price'], 0, '', ',') . 'Đ</h3>
                <span class="product-available">Còn hàng</span>
                <p>Laptop thế hệ mới mang đam mê của bạn bắt nhịp với lối sống năng động...</p>
                <div class="product-options">
                  <label>Ổ cứng
                    <select class="form-select">
                        <option value="0">512GB</option>
                        <option value="1">1024GB</option>
                    </select>
                  </label>
                  <label>Màu sắc
                    <select class="form-select">
                      <option value="0">Đỏ</option>
                    </select>
                  </label>
                </div>
                <div class="add-to-cart">
                  <label for="quantity">Số lượng</label>
                  <input type="number" id="quantity" class="form-control w-50" value="1">
                  <button class="btn btn-primary mt-3" pid="' . intval($row['product_id']) . '" id="product"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>
                </div>
              </div>
            </div>
            ';
          }
        } 
        else 
        {
          echo '<div class="col-12"><p>Không tìm thấy sản phẩm.</p></div>';
        }
        CloseCon($con);
      ?>
    </div>
  </div>
</div>

<?php
include "newsletter.html";
include "footer.html";
?>
