<?php
session_start();
include "../Database/db_connection.php";

include "sidenav.php";
include "topheader.php";
include "activitity.php";
$con=OpenCon();
function fetchData($con, $sql, $params = [])
{
    
    $con=OpenCon();
    $stmt = $con->prepare($sql);
    if (!empty($params)) {
        $types = str_repeat("s", count($params)); 
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}
CloseCon($con);
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="panel-body">
            <?php
            if (isset($_POST['success'])) {
                echo "
                <div class='col-md-12 col-xs-12' id='product_msg'>
                    <div class='alert alert-success'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a>
                        <b>Sản phẩm đã được thêm..!</b>
                    </div>
                </div>";
            }
            ?>
        </div>

        <!-- Danh sách thành viên -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách thành viên</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Mật khẩu</th>
                                    <th>SĐT</th>
                                    <th>Địa chỉ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = fetchData($con, "SELECT * FROM user_info");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['user_id']}</td>
                                            <td>{$row['first_name']}</td>
                                            <td>{$row['last_name']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['password']}</td>
                                            <td>{$row['address1']}</td>
                                            <td>{$row['address2']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='8' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách phân loại -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách phân loại</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phân loại</th>
                                    <th>Số lượng sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = fetchData($con, "SELECT c.cat_id, c.cat_title, COUNT(p.product_id) AS count_items 
                                                           FROM categories c 
                                                           LEFT JOIN products p ON c.cat_id = p.product_cat 
                                                           GROUP BY c.cat_id, c.cat_title");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['cat_id']}</td>
                                            <td>{$row['cat_title']}</td>
                                            <td>{$row['count_items']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách hãng -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Danh sách hãng</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên hãng</th>
                                    <th>Số lượng sản phẩm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $result = fetchData($con, "SELECT b.brand_id, b.brand_title, COUNT(p.product_id) AS count_items 
                                                           FROM brands b 
                                                           LEFT JOIN products p ON b.brand_id = p.product_brand 
                                                           GROUP BY b.brand_id, b.brand_title");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>{$row['brand_id']}</td>
                                            <td>{$row['brand_title']}</td>
                                            <td>{$row['count_items']}</td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center'>Không có dữ liệu</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

