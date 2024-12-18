<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$pid = $input['product_id'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

if (!$pid) {
    echo json_encode(["success" => false, "message" => "Không tìm thấy mã sản phẩm"]);
    exit;
}

try {
  $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $pid);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();

    $_SESSION['product_details'] = [
        'product_id' => $product['product_id'],
        'product_title' => $product['product_title'],
        'product_price' => $product['product_price'],
        'product_image' => $product['product_image'],
        'product_brand' => $product['product_brand'],
        'product_cat' => $product['product_cat'],
        'product_desc' => $product['product_desc'],
        'product_keywords' => $product['product_keywords'],
    ];
    echo json_encode(["success" => true, "message" => "success"]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
  }
  $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>