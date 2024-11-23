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
$qty = $input['qty'] ?? null;
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

if (!is_numeric($qty) || $qty <= 0) {
    echo json_encode(["success" => false, "message" => "Số lượng không hợp lệ"]);
    exit;
}

try {
    $query1 = "SELECT MAX(id) FROM cart";
    $result = $conn->query($query1);
    $id = 1;
    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_row();
        $id = $row[0] + 1;
    }

    $query = "INSERT INTO cart (`id`, `p_id`, `ip_add`, `user_id`, `qty`)
        VALUES (?, ?, '', ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiii", $id, $pid, $_SESSION['uid'], $qty);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "success"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>