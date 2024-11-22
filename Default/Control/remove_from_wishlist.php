<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$id = $input['id'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

if (!$id) {
    echo json_encode(["success" => false, "message" => "Sản phẩm đã được xóa."]);
    exit;
}


try {
    $query = "DELETE FROM wishlist WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["success" => true, "message" => "success"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>