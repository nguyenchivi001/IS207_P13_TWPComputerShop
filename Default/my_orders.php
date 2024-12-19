<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['uid'])) {
    header("Location: ./signin.php");
    exit();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
require './header.php';
?>

<link href="css/my_orders.css" rel="stylesheet" />
<section class="section main main-raised">
    <div class="container-fluid">
        <div class="wrap cf">
            <h1 class="projTitle">Tất cả đơn hàng của bạn</h1>
            <div class="heading cf">
                <h1>Đơn hàng</h1>
                <h1 style="margin-left:55%">Số lượng</h1>
                <a href="index.php" class="continue">Tiếp tục mua sắm</a>
            </div>
            <div class="cart">
                <?php
                $conn = OpenCon();

                $uid = $_SESSION['uid'];
                $order_query = "SELECT order_id, total_amt FROM orders WHERE user_id = ?";
                $order_stmt = $conn->prepare($order_query);
                $order_stmt->bind_param("i", $uid);
                $order_stmt->execute();
                $order_result = $order_stmt->get_result();

                if ($order_result->num_rows > 0) {
                    while ($order = $order_result->fetch_assoc()) {
                        $order_id = $order['order_id'];
                        $order_total = number_format($order['total_amt'], 0, '', ',') . 'Đ';

                        echo "<h2>Đơn hàng #$order_id</h2>";
                        echo "<ul class='cartWrap'>";

                        $product_query = "SELECT 
                            P.product_id, 
                            P.product_title, 
                            P.product_price, 
                            P.product_image, 
                            O.qty, 
                            O.amt 
                        FROM products P
                        JOIN orders_info O ON P.product_id = O.product_id
                        WHERE O.order_id = ?";
                        $product_stmt = $conn->prepare($product_query);
                        $product_stmt->bind_param("i", $order_id);
                        $product_stmt->execute();
                        $product_result = $product_stmt->get_result();

                        $subtotal = 0;

                        while ($product = $product_result->fetch_assoc()) {
                            $product_id = $product['product_id'];
                            $product_title = $product['product_title'];
                            $product_price = number_format($product['product_price'], 0, '', ',') . 'Đ';
                            $product_image = $product['product_image'];
                            $qty = $product['qty'];
                            $amt = $product['amt'];
                            $subtotal += $amt;

                            echo "
                                <li class='items even'>
                                    <div class='infoWrap'>
                                        <div class='cartSection'>
                                            <img src='../Assets/product_images/{$product_image}' alt='{$product_title}' class='itemImg' />
                                            <p class='itemNumber'>#{$product_id}</p>
                                            <h3>{$product_title}</h3>
                                            <p>{$qty} x {$product_price}</p>
                                            <p class='stockStatus'>Đã vận chuyển</p>
                                        </div>
                                        <div class='prodTotal cartSection'><p>{$qty}</p></div>
                                        <div class='prodTotal cartSection'><p>{$product_price}</p></div>
                                    </div>
                                </li>";
                        }

                        $shipping_fee = 0;
                        $tax = 0;
                        $total = $subtotal + $shipping_fee + $tax;

                        echo "
                            </ul>
                            <div class='subtotal cf'>
                                <ul>
                                    <li class='totalRow'><span class='label'>Thành tiền</span><span class='value'>" . number_format($subtotal, 0, '', ',') . "Đ</span></li>
                                    <li class='totalRow'><span class='label'>Phí vận chuyển</span><span class='value'>" . number_format($shipping_fee, 0, '', ',') . "Đ</span></li>
                                    <li class='totalRow'><span class='label'>Thuế</span><span class='value'>" . number_format($tax, 0, '', ',') . "Đ</span></li>
                                    <li class='totalRow final'><span class='label'>Tổng tiền</span><span class='value'>" . number_format($total, 0, '', ',') . "Đ</span></li>
                                </ul>
                            </div>";
                    }
                } else {
                    echo "<p>Không có đơn hàng nào.</p>";
                }

                $order_stmt->close();
                CloseCon($conn);
                ?>
            </div>
        </div>
    </div>
</section>

<?php require './footer.html'; ?>
