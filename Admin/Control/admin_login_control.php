<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Lấy dữ liệu từ request
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? null;
$password = $input['password'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// Kiểm tra CSRF token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Kiểm tra dữ liệu đầu vào
if (!$email || !$password) {
    echo json_encode(["success" => false, "message" => "Email and password are required."]);
    CloseCon($conn);
    exit;
}

try {
    // Truy vấn thông tin admin từ cơ sở dữ liệu
    $query = "SELECT * FROM admin_info WHERE admin_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu
        if (md5($password) === $admin['admin_password']) {
            // Tạo lại CSRF token mới và lưu thông tin admin vào session
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];

            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Sai tên đăng nhập hoặc mật khẩu"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid login credentials."]);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "System error occurred."]);
}

CloseCon($conn);
?>
