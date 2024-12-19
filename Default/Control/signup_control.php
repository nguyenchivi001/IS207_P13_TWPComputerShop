<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$fname = $input['fname']?? null;
$lname = $input['lname']?? null;
$phone = $input['phone']?? null;
$address1 = $input['address1']?? null;
$address2 = $input['address2']?? null;
$confirmPassword = $input['confirmPassword']?? null;
$email = $input['email'] ?? null;
$password = $input['password'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// check csrf token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Validate inputs
if (!$fname || !$lname || !$email || !$password || !$confirmPassword || !$phone || !$address1 || !$address2) {
    echo json_encode(["success" => false, "message" => "Thông tin thiếu."]);
    CloseCon($conn);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(["success" => false, "message" => "Mật khẩu không giống nhau."]);
    CloseCon($conn);
    exit;
}

// hassing password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    // Check database for user credentials
    $query1 = "SELECT MAX(user_id) FROM user_info";
    $result = $conn->query($query1);
    $id = 1;
    // Check if the query was successful
    if ($result) {
        $row = $result->fetch_row();
        $id = $row[0] + 1;
    }

    $query2 = "INSERT INTO user_info (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address1`, `address2`) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query2);
    $stmt->bind_param("isssssss", $id, $fname, $lname, $email, $hashedPassword, $phone, $address1, $address2);
    $stmt->execute();
    $stmt->close();
    echo json_encode(["success" => true, "message" => "Đăng ký thành công"]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
CloseCon($conn);
?>
