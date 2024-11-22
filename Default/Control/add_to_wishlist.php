<?php
session_start();
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
    $query1 = "SELECT MAX(id) FROM wishlist";
    $result = $conn->query($query1);
    $id = 1;
    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_row();
        $id = $row[0] + 1;
    }

    $query = "INSERT INTO wishlist (`id`, `p_id`, `ip_add`, `user_id`)
        VALUES (?, ?, '', ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $id, $pid, $_SESSION['uid']);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "success"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>