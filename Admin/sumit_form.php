<?php
// Kiểm tra sự tồn tại của biến 'success'
$link = isset($_REQUEST['success']) ? htmlspecialchars($_REQUEST['success']) : '';
if (!$link) {
    die("Đường dẫn không hợp lệ.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đang xử lý...</title>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Tự động gửi form khi trang tải xong
            document.getElementById("myform").submit();
        });
    </script>
</head>
<body>
    <!-- Form gửi dữ liệu -->
    <form action="add_product.php" method="post" id="myform">
        <input type="hidden" name="success" value="<?php echo $link; ?>">
    </form>

    <!-- Hiển thị hình ảnh loading -->
    <div style="text-align: center; padding-top: 20vh;">
        <h1>Đang xử lý...</h1>
        <img src="../images/loading-x.gif" alt="Loading..." />
    </div>
</body>
</html>
