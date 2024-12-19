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
    $check_query = "SELECT qty FROM cart WHERE p_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ii", $pid, $_SESSION['uid']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

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
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $new_qty = $row['qty'] + $qty;

        $update_query = "UPDATE cart SET qty = ? WHERE p_id = ? AND user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("iii", $new_qty, $pid, $_SESSION['uid']);
        $update_stmt->execute();

        echo json_encode(["success" => true, "message" => "Tăng số lượng sản phẩm trong giỏ hàng"]);
    } else {

        $get_id_query = "SELECT MAX(id) FROM cart";
        $result = $conn->query($get_id_query);
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
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
CloseCon($conn);
?>