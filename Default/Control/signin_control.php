<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? null;
$password = $input['password'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Validate inputs
if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Email và mật khẩu là bắt buộc."]);
    CloseCon($conn);
    exit;
}

try {
    $query = "SELECT * FROM user_info WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['uid'] = $user['user_id'];
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Thông tin đăng nhập không chính xác."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Thông tin đăng nhập không chính xác."]);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}
CloseCon($conn);
?>
