<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$cid = $input['c_id'] ?? null;
$qty = $input['quantity'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;
$pid = $input['product_id'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

if (!$cid) {
    echo json_encode(["success" => false, "message" => "Không tìm thấy sản phẩm trong giỏ hàng"]);
    exit;
}

if (!is_numeric($qty) || $qty < 0) {
    echo json_encode(["success" => false, "message" => "Số lượng không hợp lệ"]);
    exit;
}

try {
    $inventory_query = "SELECT quantity FROM products WHERE product_id = ?";
    $inventory_stmt = $conn->prepare($inventory_query);
    $inventory_stmt->bind_param("i", $pid);
    $inventory_stmt->execute();
    $inventory_result = $inventory_stmt->get_result();

    if ($inventory_result->num_rows > 0) {
        $inventory = $inventory_result->fetch_assoc();
        $quantity = $inventory['quantity'];
        if ($quantity < $qty) {
            echo json_encode(["success" => false, "message" => "Sản phẩm đã hết hàng"]);
            exit;
        }
    }

    $update_query = "UPDATE cart SET qty = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $qty, $cid);
    $update_stmt->execute();


    echo json_encode(["success" => true, "message" => "Cập nhật số lượng sản phẩm trong giỏ hàng"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>