<?php
session_start();
include "../Database/db_connection.php" ;
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
error_reporting(0);
///pagination
$page = $_GET['page'];

if ($page == "" || $page == "1") {
  $page1 = 0;
} else {
  $page1 = ($page * 10) - 10;
}
include "sidenav.php";
include "topheader.php";
?>

<!-- Nội dung chính -->
<div class="content">
    <div class="container-fluid">
      <!-- your content here -->
      <div class="col-md-14">
        <div class="card ">
          <div class="card-header card-header-primary">
            <h4 class="card-title">Hóa đơn <?php echo $page;?> </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive ps">
              <table class="table table-hover tablesorter " id="">
                <thead class=" text-primary">
                  <tr><th>STT</th><th>Sản phẩm</th><th>SĐT / Email</th><th>Địa chỉ</th><th>Số lượng</th><th>Tổng tiền</th>
                </tr></thead>
                <tbody>
    <?php
    $con=OpenCon();
    // Truy vấn dữ liệu từ bảng orders_info
    $query = "SELECT * FROM orders";
    $run = mysqli_query($con, $query);

    // Kiểm tra nếu có dữ liệu
    if (mysqli_num_rows($run) > 0) {
        // Duyệt qua từng đơn hàng
        while ($row = mysqli_fetch_assoc($run))
        {
            $order_id = $row['order_id'];
            $email = $row['email'];
            $address = $row['address'];
            $total_amount = $row['total_amt'];
            $user_id = $row['user_id'];
            $qty = $row['prod_count'];
    ?>
            <tr>
                <td><?php echo htmlspecialchars($order_id); ?></td>
                <td>
                    <?php
                    $con=OpenCon();
                    // Truy vấn sản phẩm liên quan đến đơn hàng
                    $query1 = "SELECT product_id FROM orders_info WHERE order_id = $order_id";
                    $run1 = mysqli_query($con, $query1);

                        // Duyệt qua các sản phẩm trong đơn hàng và hiển thị tên sản phẩm
                        while ($row1 = mysqli_fetch_assoc($run1)) {
                          $product_id = $row1['product_id'];

                          // Truy vấn thông tin sản phẩm
                          $query2 = "SELECT product_title FROM products WHERE product_id = $product_id";
                          $run2 = mysqli_query($con, $query2);

                          // Hiển thị tên sản phẩm
                          while ($row2 = mysqli_fetch_assoc($run2)) {
                            $product_title = $row2['product_title'];
                            echo htmlspecialchars($product_title) . "<br>";
                          }
                        }
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($email); ?></td>
<td><?php echo htmlspecialchars($address); ?></td>
                <td><?php echo htmlspecialchars($qty); ?></td>
                <td><?php echo htmlspecialchars($total_amount); ?></td>
            </tr>
    <?php
        }
    else {
        // Nếu không có dữ liệu
        echo "<center><h2>Không có dữ liệu hóa đơn</h2><br><hr></center>";
    }
    CloseCon($con);
    ?>
</tbody>

            </table>

            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
              <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
              <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<?php
include "footer.php";
?>