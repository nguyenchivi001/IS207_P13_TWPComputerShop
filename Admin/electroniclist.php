<?php
session_start();
include("db.php");
error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
    $product_id = $_GET['product_id'];

    // Truy vấn để lấy tên file ảnh
    $stmt = $con->prepare("SELECT product_image FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($picture);
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        $path = "../product_images/$picture";

        // Kiểm tra và xóa file ảnh
        if (file_exists($path)) {
            if (!unlink($path)) {
                echo "<script>alert('Không thể xóa ảnh sản phẩm.');</script>";
            }
        }
    }

    $stmt->close();

    // Xóa sản phẩm khỏi cơ sở dữ liệu
    $stmt = $con->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        die("Không thể xóa sản phẩm: " . $stmt->error);
    }
    $stmt->close();
}

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * 10;

include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-14">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Products List</h4>
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                        <label class="btn btn-sm btn-primary btn-simple active" id="0">
                            <input type="radio" name="options" autocomplete="off" checked=""> Electronic
                        </label>
                        <label class="btn btn-sm btn-primary btn-simple" id="1">
                            <input type="radio" name="options" autocomplete="off"> Clothes
                        </label>
                        <label class="btn btn-sm btn-primary btn-simple" id="2">
                            <input type="radio" name="options" autocomplete="off"> Home Appliances
                        </label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table table-hover tablesorter" id="page1">
                            <thead class="text-primary">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>
                                        <a class="btn btn-primary" href="add_products.php">Add New</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $con->prepare("SELECT product_id, product_image, product_title, product_price FROM products WHERE product_cat = 1 LIMIT ?, 10");
                                $stmt->bind_param("i", $offset);
                                $stmt->execute();
                                $stmt->bind_result($product_id, $image, $product_name, $price);

                                while ($stmt->fetch()) {
                                    echo "
                                    <tr>
                                        <td><img src='../product_images/$image' style='width:50px; height:50px; border:groove #000'></td>
                                        <td>$product_name</td>
                                        <td>$price</td>
                                        <td>
                                            <a class='btn btn-success' href='clothes_list.php?product_id=$product_id&action=delete'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                                $stmt->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                    $result = $con->query("SELECT COUNT(*) as total FROM products WHERE product_cat = 1");
                    $row = $result->fetch_assoc();
                    $total_pages = ceil($row['total'] / 10);

                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<li class='page-item'><a class='page-link' href='productlist.php?page=$i'>$i</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
