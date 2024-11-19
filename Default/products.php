<?php
include "header.php";
?>

<link rel="stylesheet" href="css/products.css">
<div class="section main main-raised">
  <div class="container">
    <!-- Bộ lọc và sắp xếp -->
    <div class="filter-sort">
      <form method="GET" class="form-inline">
        <input type="hidden" name="q" value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q'], ENT_QUOTES) : '' ?>">
        <input type="hidden" name="cid" value="<?= isset($_GET['cid']) ? intval($_GET['cid']) : 0 ?>">
        <div class="form-group">
          <label for="sort" class="mr-2">Sắp xếp:</label>
          <select name="sort" id="sort" class="form-control mr-4">
            <option value="default" <?= !isset($_GET['sort']) || $_GET['sort'] == 'default' ? 'selected' : '' ?>>Mặc định</option>
            <option value="asc" <?= isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
            <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
          </select>
        </div>
        <div class="form-group">
          <label for="price" class="mr-2">Giá:</label>
          <select name="price" id="price" class="form-control mr-4">
            <option value="all" <?= !isset($_GET['price']) || $_GET['price'] == 'all' ? 'selected' : '' ?>>Tất cả</option>
            <option value="0-10000000" <?= isset($_GET['price']) && $_GET['price'] == '0-10000000' ? 'selected' : '' ?>>Dưới 10,000,000Đ</option>
            <option value="10000000-50000000" <?= isset($_GET['price']) && $_GET['price'] == '10000000-50000000' ? 'selected' : '' ?>>10,000,000Đ - 50,000,000Đ</option>
            <option value="50000000-100000000" <?= isset($_GET['price']) && $_GET['price'] == '50000000-100000000' ? 'selected' : '' ?>>50,000,000Đ - 100,000,000Đ</option>
            <option value="100000000-0" <?= isset($_GET['price']) && $_GET['price'] == '100000000-0' ? 'selected' : '' ?>>Trên 100,000,000Đ</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Áp dụng</button>
      </form>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row">
      <?php
        $con = OpenCon();

        // Từ khoá tìm kiếm
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        // Tách từ khoá tìm kiếm thành các từ riêng biệt
        if (!empty($q)) {
          $keyword = trim($q, '%');
          $search_terms = preg_split('/\s+/', $keyword);
          $search_conditions = [];

          foreach ($search_terms as $term) {
              $search_conditions[] = "(P.product_title LIKE ? OR P.product_desc LIKE ?)";
          }

          // Kết hợp tất cả điều kiện tìm kiếm bằng AND
          $search_condition = " AND (" . implode(' AND ', $search_conditions) . ")";
        }
        else {
          $search_condition = "";
        }

        // Lấy tham số GET
        $cid = isset($_GET['cid']) ? intval($_GET['cid']) : 0;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
        $price = isset($_GET['price']) ? $_GET['price'] : 'all';

        //Phân trang
        $limit = 12;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * $limit;

        // Bộ lọc giá
        $price_condition = "";
        if ($price != 'all') {
            [$min_price, $max_price] = explode('-', $price);
            $min_price = intval($min_price);
            $max_price = intval($max_price);
            if ($max_price > 0) {
                $price_condition = " AND P.product_price BETWEEN $min_price AND $max_price";
            } else {
                $price_condition = " AND P.product_price >= $min_price";
            }
        }

        // Sắp xếp
        $order_by = "";
        if ($sort == 'asc') {
            $order_by = " ORDER BY P.product_price ASC";
        } elseif ($sort == 'desc') {
            $order_by = " ORDER BY P.product_price DESC";
        }
        

        // Câu truy vấn sản phẩm
        if (!empty($q)) {
          $sql = "SELECT * FROM products AS P 
          JOIN categories AS C ON P.product_cat = C.cat_id 
          WHERE 1=1 $search_condition $price_condition $order_by 
          LIMIT ? OFFSET ?";

          $stmt = $con->prepare($sql);
          $params = [];
          foreach ($search_terms as $term) {
              $params[] = "%" . $con->real_escape_string($term) . "%";
              $params[] = "%" . $con->real_escape_string($term) . "%";
          }
          
          $params[] = $limit;
          $params[] = $offset;
          
          $type_string = str_repeat("ss", count($search_terms)) . "ii";
          $stmt->bind_param($type_string, ...$params);

          $stmt->execute();
          $result = $stmt->get_result();
        } else {
          $sql = "SELECT * FROM products AS P 
          JOIN categories AS C ON P.product_cat = C.cat_id 
          WHERE C.cat_id = ? $price_condition $order_by 
          LIMIT ? OFFSET ?";

          $stmt = $con->prepare($sql);

          $stmt->bind_param("iii", $cid, $limit, $offset);

          $stmt->execute();
          $result = $stmt->get_result();
        }
        

        if (!empty($q)) {
          $keyword = trim($q, '%');
          echo '
            <div class="search-keyword mb-4">
              <p>Bạn đang tìm kiếm từ khóa: <strong>' . htmlspecialchars($keyword, ENT_QUOTES) . '</strong></p>
            </div>
          ';
        }
      
        // Hiển thị sản phẩm
        if ($result->num_rows > 0) {
          $count = 0;
          while ($row = $result->fetch_assoc()) {
            if ($count % 4 == 0 && $count != 0) {
              echo '</div><div class="row">';
            }
            echo '
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
              <div class="product-card">
                <div class="product-img">
                  <img src="../Assets/product_images/' . htmlspecialchars($row['product_image'], ENT_QUOTES) . '" alt="">
                </div>
                <div class="product-info">
                  <h5 class="product-name">' . htmlspecialchars($row['product_title'], ENT_QUOTES) . '</h5>
                  <p class="product-price">' . number_format($row['product_price'], 0, '', ',') . 'Đ</p>
                  <button class="btn btn-primary btn-sm" pid="' . intval($row['product_id']) . '" id="product">Thêm vào giỏ hàng</button>
                </div>
              </div>
            </div>
            ';
            $count++;
          }
        } else {
          echo '<div class="col-12"><p>Không tìm thấy sản phẩm.</p></div>';
        }

        // Tổng số sản phẩm
        $count_sql = "SELECT COUNT(*) AS total FROM products WHERE product_cat = ?";
        $count_stmt = $con->prepare($count_sql);
        $count_stmt->bind_param("i", $cid);
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        $total = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total / $limit);

        CloseCon($con);
      ?>
    </div>

    <!-- Phân trang -->
    <div class="pagination">
      <?php if ($total_pages > 1): ?>
        <nav>
          <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link" href="?cid=<?= $cid ?>&price=<?= $price ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">Trước</a>
              </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?cid=<?= $cid ?>&price=<?= $price ?>&sort=<?= $sort ?>&page=<?= $i ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
            <?php if ($page < $total_pages): ?>
              <li class="page-item">
                <a class="page-link" href="?cid=<?= $cid ?>&price=<?= $price ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">Tiếp</a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php
include "newsletter.html";
include "footer.html";
?>
