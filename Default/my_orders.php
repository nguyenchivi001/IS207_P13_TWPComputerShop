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
                <ul class="cartWrap">
                    <?php
                    $conn = OpenCon();

                    $uid = $_SESSION['uid'];
                    $sql = "SELECT c.order_id, a.product_id, a.product_title, a.product_price, a.product_image, b.qty, b.amt, c.total_amt
                            FROM products a
                            JOIN order_products b ON a.product_id = b.product_id
                            JOIN orders_info c ON b.order_id = c.order_id
                            WHERE c.user_id = ?
                            ORDER BY c.order_id DESC";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $uid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $prev_order_id = 0;
                        $prev_total = 0;

                        while ($row = $result->fetch_assoc()) {
                            $order_id = $row['order_id'];
                            $product_id = $row['product_id'];
                            $product_title = $row['product_title'];
                            $product_price = number_format($row['product_price'], 0, '', ',') . 'Đ';
                            $product_image = $row['product_image'];
                            $qty = $row['qty'];
                            $total_amt = number_format($row['total_amt'], 0, '', ',') . 'Đ';

                            if ($prev_order_id !== $order_id && $prev_order_id !== 0) {
                                echo "</ul></div>
                                    <div class='subtotal cf'>
                                        <ul>
                                            <li class='totalRow'><span class='label'>Thành tiền</span><span class='value'>{$prev_total}</span></li>
                                            <li class='totalRow'><span class='label'>Phí vận chuyển</span><span class='value'>0Đ</span></li>
                                            <li class='totalRow'><span class='label'>Thuế</span><span class='value'>0Đ</span></li>
                                            <li class='totalRow final'><span class='label'>Tổng tiền</span><span class='value'>{$prev_total}</span></li>
                                        </ul>
                                    </div>
                                    <div class='cart'>
                                        <ul class='cartWrap'>";
                            }

                            echo "<li class='items even'>
                                    <div class='infoWrap'>
                                        <div class='cartSection'>
                                            <img src='product_images/{$product_image}' alt='{$product_title}' class='itemImg' />
                                            <p class='itemNumber'>#{$product_id}</p>
                                            <h3>{$product_title}</h3>
                                            <p>{$qty} x {$product_price}</p>
                                            <p class='stockStatus'>Đã vận chuyển</p>
                                        </div>
                                        <div class='prodTotal cartSection'><p>{$qty}</p></div>
                                        <div class='prodTotal cartSection'><p>{$product_price}</p></div>
                                        <div class='cartSection removeWrap'>
                                            <a href='#' class='remove'>x</a>
                                        </div>
                                    </div>
                                </li>";

                            $prev_order_id = $order_id;
                            $prev_total = $total_amt;
                        }

                        if ($prev_order_id !== 0) {
                            echo "</ul></div>
                                <div class='subtotal cf'>
                                    <ul>
                                        <li class='totalRow'><span class='label'>Thành tiền</span><span class='value'>{$prev_total}</span></li>
                                        <li class='totalRow'><span class='label'>Phí vận chuyển</span><span class='value'>0Đ</span></li>
                                        <li class='totalRow'><span class='label'>Thuế</span><span class='value'>0Đ</span></li>
                                        <li class='totalRow final'><span class='label'>Tổng tiền</span><span class='value'>{$prev_total}</span></li>
                                    </ul>
                                </div>";
                        }

                        $stmt->close();
                    }

                    CloseCon($conn);
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php require './footer.html'; ?>
