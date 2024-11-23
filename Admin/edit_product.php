<?php
session_start();
include "../Database/db.php";

$product_id = $_REQUEST['product_id'] ?? 0;
if (!is_numeric($product_id)) {
    die("Invalid product ID");
}

// Lấy thông tin sản phẩm hiện tại
$stmt = $con->prepare("SELECT `product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords` FROM `products` WHERE `product_id` = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$stmt->bind_result($product_id, $product_type, $brand, $product_name, $price, $details, $pic_name, $tags);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_save'])) {
    // Lấy dữ liệu từ form
    $product_name = htmlspecialchars(trim($_POST['product_name']));
    $details = htmlspecialchars(trim($_POST['details']));
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT) ?? 0;
    $product_type = filter_var($_POST['product_type'], FILTER_VALIDATE_INT);
    $brand = filter_var($_POST['brand'], FILTER_VALIDATE_INT);
    $tags = htmlspecialchars(trim($_POST['tags']));

    // Xử lý tệp ảnh tải lên
    if (!empty($_FILES['picture']['name'])) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $picture_type = $_FILES['picture']['type'];
        $picture_tmp_name = $_FILES['picture']['tmp_name'];
        $picture_size = $_FILES['picture']['size'];

        if (in_array($picture_type, $allowed_types) && $picture_size <= 5000000) {
            $safe_name = time() . "_" . basename($_FILES['picture']['name']);
            $upload_path = "../../product_images/" . $safe_name;

            if (move_uploaded_file($picture_tmp_name, $upload_path)) {
                $pic_name = $safe_name; // Cập nhật tên tệp nếu tải lên thành công
            } else {
                die("Error uploading file.");
            }
        } else {
            die("Invalid file type or size.");
        }
    }

    // Cập nhật cơ sở dữ liệu
    $stmt = $con->prepare("UPDATE `products` SET `product_title` = ?, `product_cat` = ?, `product_brand` = ?, `product_price` = ?, `product_desc` = ?, `product_image` = ?, `product_keywords` = ? WHERE `product_id` = ?");
    $stmt->bind_param("siidsssi", $product_name, $product_type, $brand, $price, $details, $pic_name, $tags, $product_id);

    if ($stmt->execute()) {
        header("Location: products_list.php");
        exit();
    } else {
        die("Error updating product.");
    }
}

include "sidenav.php";
include "topheader.php";
?>

<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="title">Sửa sản phẩm</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product_name); ?>" required class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <img src='<?= "../../product_images/" . htmlspecialchars($pic_name); ?>' style='width:50px; height:50px; border:groove #000'>
                                    <div>
                                        <label for="">Thêm ảnh</label>
                                        <input type="file" name="picture" class="btn btn-fill btn-success">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea rows="4" cols="80" id="details" name="details" required class="form-control"><?= htmlspecialchars($details); ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Đơn giá</label>
                                        <input type="text" id="price" name="price" value="<?= htmlspecialchars($price); ?>" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h5 class="title">Phân loại</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Loại sản phẩm</label>
                                        <select id="product_type" name="product_type" required class="form-control">
                                            <option value="" style="color:black;">Chọn phân loại</option>
                                            <?php
                                            $result1 = $con->query("SELECT `cat_id`, `cat_title` FROM `categories` ORDER BY `cat_id` ASC");
                                            while ($row = $result1->fetch_assoc()) {
                                                $selected = $row['cat_id'] == $product_type ? "selected" : "";
                                                echo "<option value='{$row['cat_id']}' style='color:black;' $selected>{$row['cat_title']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Tên hãng</label>
                                        <select id="brand" name="brand" required class="form-control">
                                            <option value="" style="color:black;">Chọn hãng</option>
                                            <?php
                                            $result2 = $con->query("SELECT `brand_id`, `brand_title` FROM `brands`");
                                            while ($row = $result2->fetch_assoc()) {
                                                $selected = $row['brand_id'] == $brand ? "selected" : "";
                                                echo "<option value='{$row['brand_id']}' style='color:black;' $selected>{$row['brand_title']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Từ khóa</label>
                                        <input type="text" id="tags" name="tags" value="<?= htmlspecialchars($tags); ?>" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="btn_save" name="btn_save" class="btn btn-fill btn-primary">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php
include "footer.php";
?>
