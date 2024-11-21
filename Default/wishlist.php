<?php require './header.php'?>
<section id="wishlist-section" class="container-fluid min-vh-100">
    <div class="table-responsive">
        <table id="wishlist" class="table table-hover table-striped rounded overflow-hidden shadow-sm" id="">
        <thead>
            <tr>
                <th style="width:50%" class="text-color">Sản phẩm</th>
                <th style="width:10%" class="text-color">Đơn giá</th>
                <th style="width:10%" class="text-color"></th>
                <th style="width:20%" class="text-color"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
                try {
                    $conn = OpenCon();
                    $query_products = "SELECT id, p_id FROM wishlist WHERE user_id = ?";
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
                    $item->p_title = $product_information[3];
                    $item->p_price = $product_information[4];
                    $item->p_desc = $product_information[5];
                    $item->p_img = $product_information[6];
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
                                <div class="btn-group">
                                    <a
                                    class="btn remove-btn delete-wishlist-item" 
                                    wid="' . htmlspecialchars($item->id) . '" 
                                    token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>        
                                </div>                            
                            </td>
                            <td>
                                <a 
                                class="btn primary-btn text-color move-to-cart-btn"
                                wid="' . htmlspecialchars($item->id) . '" 
                                pid="' . htmlspecialchars($item->p_id) . '" 
                                token="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '"
                                >
                                Chuyển sang giỏ hàng <i class="fa fa-angle-right"></i> </a>
                            </td>
                        </tr>
                        ';
                    }
                    } else {
                    echo '
                        <tr>
                        <td colspan="6" class="text-center">Không có sản phẩm nào trong danh sách yêu thích.</td>
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
        <td><a href="./index.php" class="btn primary-btn"><i class="fa fa-angle-left"></i> Tiếp tục mua sắm</a></td>
        <td ></td>
        <td class="hidden-xs text-center"></td>
        <td></td>
        </tfoot>
        </table>
    </div>
</section>
<script src="./js/action.js"></script>
<script>
  document.querySelectorAll(".delete-wishlist-item").forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('wid');
        const csrfToken = button.getAttribute('token');
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
          removeFromWishlist(id, csrfToken);
        }
    });
  });
  document.querySelectorAll(".move-to-cart-btn").forEach(button => {
    button.addEventListener('click', () => {
        const id = button.getAttribute('wid');
        const productId = button.getAttribute('pid');
        const csrfToken = button.getAttribute('token');
        if (confirm('Bạn có muốn chuyển sản phẩm này sang giỏ hàng?')) {
          addToCart(productId, 1, csrfToken);
          removeFromWishlist(id, csrfToken);
        }
    });
  });
</script>
<?php require './footer.html'?>