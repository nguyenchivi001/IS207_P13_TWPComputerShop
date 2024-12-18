<?php 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if (!isset($_SESSION['uid'])) {
  header("Location: ./signin.php");
}
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require './header.php';
?>
<section class="section">
  <div class="container-fluid min-vh-100">	
      <div id="cart_checkout">
        <div class="table-responsive">
          <table id="cart" class="table table-hover table-striped rounded overflow-hidden shadow-sm" id="" >
              <thead>
              <tr>
                <th class="text-color" style="width:50%">Sản phẩm</th>
                <th class="text-color" style="width:10%">Đơn giá</th>
                <th class="text-color" style="width:8%">Số lượng</th>
                <th class="text-color text-center" style="width:7%">Tổng tiền</th>
                <th class="text-color" style="width:10%"></th>
                <th class="text-color" style="width:15%"></th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $total_price_for_all_products = 0;
                try {
                  $conn = OpenCon();
                  $query_products = "SELECT id, p_id, qty FROM cart WHERE user_id = ?";
                  $query_prpduct_information = "SELECT * FROM products WHERE product_id = ?";
                  $stmt_products = $conn->prepare($query_products);

                  $stmt_products->bind_param("i", $_SESSION['uid']);
                  $stmt_products->execute();
                  $result_products = $stmt_products->get_result();

                  $information_will_show = [];  

                  while ($p = $result_products->fetch_assoc()) {
                    $stmt_prpduct_information = $conn->prepare($query_prpduct_information);
                    $stmt_prpduct_information->bind_param("i", $p['p_id']);
                    $stmt_prpduct_information->execute();
                    $result_prpduct_information = $stmt_prpduct_information->get_result();
                    $product_information = $result_prpduct_information->fetch_row();
                    $item = new stdClass();
                    $item->id = $p['id'];
                    $item->p_id = $p['p_id'];
                    $item->qty = $p['qty'];
                    $item->p_title = $product_information[3];
                    $item->p_price = $product_information[4];
                    $item->p_desc = $product_information[5];
                    $item->p_img = $product_information[6];
                    $total_price_for_all_products += $item->p_price * $item->qty;
                    array_push($information_will_show, $item);
                  }
                  if (sizeof($information_will_show) > 0) {
                    foreach ($information_will_show as $item) {
                      echo '
                        <tr>
                          <td>
                              <div class="row">
                                  <div class="col-lg-6 product-line overflow-auto">
                                      <img class="w-50" src="../Assets/img/product_images/'. htmlspecialchars($item->p_img) .'"/>
                                      <h4><a href="#" class="text-color">' . htmlspecialchars($item->p_title) . '</a></h4>
                                  </div>
                                  <div class="col-lg-6 product-line overflow-auto">
                                      <p class="fw-normal text-color">' . htmlspecialchars($item->p_desc) . '</p>
                                  </div>
                              </div>
                          </td>
                          <td><input type="text" class="form-control price" value="' . htmlspecialchars($item->p_price) . '" readonly="readonly"></td>
                          <td>
                              <input type="number" name="quantity" min="1" value="' . htmlspecialchars($item->qty) . '" class="form-control">
                          </td>
                          <td class="text-center"><input type="text" class="form-control total" value="' . htmlspecialchars($item->p_price * $item->qty) . '" readonly="readonly"></td>
                          <td>
                              <div class="btn-group">
                                  <a 
                                    class="btn update-btn update-cart-item"
                                    cid="' . htmlspecialchars($item->id) . '" 
                                    pid="' . htmlspecialchars($item->p_id) . '" 
                                    token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '">
                                    <i class="fa fa-refresh"></i>
                                  </a>
                                  <a
                                    class="btn remove-btn delete-cart-item" 
                                    cid="' . htmlspecialchars($item->id) . '" 
                                    token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                                  >
                                      <i class="fa-solid fa-trash"></i>
                                  </a>        
                              </div>                            
                          </td>
                          <td>
                              <a 
                                class="btn primary-btn text-color move-to-wishlist-btn"
                                pid="' . htmlspecialchars($item->p_id) . '" 
                                cid="' . htmlspecialchars($item->id) . '" 
                                token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                              >
                                Chuyển sang yêu thích <i class="fa fa-angle-right"></i> </a>
                          </td>
                        </tr>
                      ';
                    }
                  } else {
                    echo '
                      <tr>
                        <td colspan="6" class="text-center">Không có sản phẩm nào trong giỏ hàng.</td>
                      </tr>
                    ';
                  }
                  CloseCon($conn);
                } catch (Exception $e) {
                  //later
                }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <td><a href="./index.php" class="btn primary-btn texto-color"><i class="fa fa-angle-left"></i> Tiếp tục mua sắm</a></td>
                <td colspan="2" class=""></td>
                <?php 
                  if ($total_price_for_all_products > 0) {
                    echo '
                    <td class="hidden-xs text-center"><b class="text-color">Tổng tiền: '. htmlspecialchars($total_price_for_all_products) .'</b></td>
                    <td>   
                      <a id="checkout-btn" class="btn btn-success">Thanh toán</a>
                    </td>
                    ';
                  } else {
                    echo '
                    <td class="hidden-xs text-center"><b class="text-color"></b></td>
                    <td>
                    </td>
                    ';
                  }
                ?>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
  </div>
</section>	
<script src="./js/action.js"></script>
<script>
  document.querySelectorAll(".delete-cart-item").forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('cid');
        const csrfToken = button.getAttribute('token');
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
          removeFromCart(id, csrfToken);
        }
    });
  });
  document.querySelectorAll(".move-to-wishlist-btn").forEach(button => {
    button.addEventListener('click', () => {
        const productId = button.getAttribute('pid');
        const csrfToken = button.getAttribute('token');
        const id = button.getAttribute('cid');
        if (confirm('Bạn có muốn chuyển sản phẩm này sang danh sách yêu thích?')) {
          addToWishlist(productId, csrfToken);
          removeFromCart(id, csrfToken);
        }
    });
  });
  document.querySelectorAll(".update-cart-item").forEach(button => {
    button.addEventListener('click', () => {
        const csrfToken = button.getAttribute('token');
        const id = button.getAttribute('cid');
        const quantityInput = button.closest('tr').querySelector('input[name="quantity"]');
        const quantity = quantityInput.value;
        const quantityInt = parseInt(quantity, 10);
        const pid = button.getAttribute('pid');
        if (confirm('Bạn có chắc chắn muốn cập nhật số lượng sản phẩm này?')) {
          updateCart(id, quantityInt, csrfToken, pid);
        }
    });
  });
  document.getElementById('checkout-btn').addEventListener('click', () => {
    document.location.href = './checkout.php';
  })
</script>
<?php require './footer.html'?>
