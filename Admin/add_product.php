<?php
session_start();
include "../Database/db.php";

if (isset($_POST['btn_save'])) {
    $product_name = $_POST['product_name'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $c_price = $_POST['c_price'];
    $product_type = $_POST['product_type'];
    $brand = $_POST['brand'];
    $tags = $_POST['tags'];

    // Kiểm tra tính hợp lệ của dữ liệu (basic validation)
    if (empty($product_name) || empty($details) || empty($price) || empty($product_type) || empty($brand)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit;
    }

    // Kiểm tra ảnh
    $picture_name = $_FILES['picture']['name'];
    $picture_type = $_FILES['picture']['type'];
    $picture_tmp_name = $_FILES['picture']['tmp_name'];
    $picture_size = $_FILES['picture']['size'];

    // Kiểm tra loại ảnh và kích thước
    if ($picture_type == "image/jpeg" || $picture_type == "image/jpg" || $picture_type == "image/png" || $picture_type == "image/gif") {
        if ($picture_size <= 50000000) {
            // Tạo tên file duy nhất cho ảnh
            $pic_name = time() . "_" . $picture_name;
            move_uploaded_file($picture_tmp_name, "../product_images/" . $pic_name);
            
            // Sử dụng prepared statements để tránh SQL injection
            $stmt = $con->prepare("INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $product_type, $brand, $product_name, $price, $details, $pic_name, $tags);
            
            if ($stmt->execute()) {
                header("Location: sumit_form.php?success=1");
            } else {
                echo "Lỗi khi thêm sản phẩm.";
            }

            // Đóng statement
            $stmt->close();
        } else {
            echo "Ảnh quá lớn. Vui lòng chọn ảnh dưới 50MB.";
        }
    } else {
        echo "Loại file không hợp lệ. Vui lòng chọn hình ảnh có định dạng .jpg, .jpeg, .png, hoặc .gif.";
    }

    mysqli_close($con);
}

include "sidenav.php";
include "topheader.php";
?>

    <div class="content">
      <div class="container-fluid">
        <form
          action=""
          method="post"
          type="form"
          name="form"
          enctype="multipart/form-data"
        >
          <div class="row">
            <div class="col-md-7">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h5 class="title">Thêm sản phẩm</h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="input-label">Tên sản phẩm</label>
                        <input
                          type="text"
                          id="product_name"
                          required
                          name="product_name"
                          class="form-control"
                        />
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="">
                        <label for="">Thêm ảnh</label>
                        <input
                          type="file"
                          name="picture"
                          required
                          class="btn btn-fill btn-success"
                          id="picture"
                        />
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="input-label">Mô tả</label>
                        <textarea
                          rows="4"
                          cols="80"
                          id="details"
                          required
                          name="details"
                          class="form-control"
                        ></textarea>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="input-label">Đơn giá</label>
                        <input
                          type="text"
                          id="price"
                          name="price"
                          required
                          class="form-control"
                        />
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
                        <label class="input-label" for="">Loại sản phẩm</label>
                        <select
                          id="product_type"
                          name="product_type"
                          required
                          class="form-control"
                        >
                          <option value="" style="color: black">
                            Chọn phân loại
                          </option>
                          <?php 
                                
                          $result1=mysqli_query($con,"SELECT * FROM `categories` ORDER BY `cat_id` ASC") or die ("query 1 incorrect.....");

                          while(list($cat_id,$cat_title)=mysqli_fetch_array($result1))
                          {
                          
                              if($cat_id==$product_type){
                                  echo "<option value='$cat_id' style='color:black;' selected>$cat_title</option>";
                              }else{
                                  echo "<option value='$cat_id' style='color:black;'>$cat_title</option>";
                              }
                          }
                          
                      ?>
                  </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="input-label" for="">Tên hãng</label>
                        <select
                          id="brand"
                          name="brand"
                          required
                          class="form-control"
                        >
                          <option value="" style="color: black">
                            Chọn hãng
                          </option>
                          <?php
                                    $result2=mysqli_query($con,"SELECT * FROM `brands`") or die ("query 1 incorrect.....");

                                    while(list($brand_id,$brand_title)=mysqli_fetch_array($result2))
                                    {
                                        if($brand_id==$brand){
                                            echo "<option value='$brand_id' style='color:black;' selected>$brand_title</option>";
                                        }else{
                                            echo "<option value='$brand_id' style='color:black;'>$brand_title</option>";
                                        }
                                    }
                                ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="input-label">Từ khóa</label>
                        <input
                          type="text"
                          id="tags"
                          name="tags"
                          required
                          class="form-control"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button
                    type="submit"
                    id="btn_save"
                    name="btn_save"
                    required
                    class="btn btn-fill btn-primary"
                  >
                    Cập nhật
                  </button>
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