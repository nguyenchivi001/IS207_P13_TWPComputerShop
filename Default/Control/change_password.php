<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

$input = json_decode(file_get_contents("php://input"), true);
$oldpass = $input['old_password'] ?? null;
$newpass = $input['new_password'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Validate inputs
if (!$oldpass || !$newpass) {
    echo json_encode(["success" => false, "message" => "Thông tin không đầy đủ"]);
    CloseCon($conn);
    exit;
}

try {
    $query = "SELECT password from user_info where user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($oldpass, $user['password'])) {
            $hashedPassword = password_hash($newpass, PASSWORD_BCRYPT);
            $get_id_query = "UPDATE user_info SET password = ? where user_id = ?";
            $stmt1 = $conn->prepare($get_id_query);
            $stmt1->bind_param("si", $hashedPassword, $_SESSION['uid']);
            $stmt1->execute();
            $stmt1->execute();
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Mật khẩu không chính xác"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Có lỗi xảy ra"]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Đã xảy ra lỗi hệ thống."]);
}

CloseCon($conn);
?>
