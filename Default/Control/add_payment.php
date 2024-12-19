<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
header("Content-Type: application/json");
include "../../Database/db_connection.php";

$conn = OpenCon();

// Read input data
$input = json_decode(file_get_contents("php://input"), true);
$fname = $input['fullname'] ?? null;
$email = $input['email'] ?? null;
$address = $input['address'] ?? null;
$city = $input['city'] ?? null;
$zip = $input['zip'] ?? null;
$cardname = $input['cardname'] ?? null;
$cardNumber = $input['cardNumber'] ?? null;
$expdate = $input['expdate'] ?? null;
$cvv = $input['cvv'] ?? null;
$csrf_token = $input['csrf_token'] ?? null;

// Check CSRF token
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Check input completeness
if (!$input || !$fname || !$email || !$address || !$city || !$zip || !$cardname || !$cardNumber || !$expdate || !$cvv) {
    echo json_encode(["success" => false, "message" => "Thiếu thông tin"]);
    exit;
}

try {
    $query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_items = 0;

    while ($row = $result->fetch_assoc()) {
        $inventory_query = "SELECT product_title, quantity FROM products WHERE product_id = ?";
        $inventory_stmt = $conn->prepare($inventory_query);
        $inventory_stmt->bind_param("i", $row['p_id']);
        $inventory_stmt->execute();
        $inventory_result = $inventory_stmt->get_result();

        if ($inventory_result->num_rows > 0) {
            $inventory = $inventory_result->fetch_assoc();
            $quantity = $inventory['quantity'];
            if ($quantity < $row['qty']) {
                echo json_encode(["success" => false, "message" => "Sản phẩm " . $inventory['product_title'] . " đã hết hàng"]);
                exit;
            }
            $total_items += $row['qty'];
        }
    }

    $order_query = "INSERT INTO orders (`user_id`, `f_name`, `email`, `address`, `city`, `state`, `zip`, `cardname`, `cardnumber`, `expdate`, `prod_count`, `total_amt`, `cvv`, `p_status`)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $state = "Viet Nam";
    $p_status="Uncomplete";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("isssssssssiiss", $_SESSION['uid'], $fname, $email, $address, $city, $state, $zip, $cardname, $cardNumber, $expdate, $total_items, $_SESSION['total_price'], $cvv, $p_status);
    $order_stmt->execute();
    $order_stmt->close();
    
    $query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();

    $query1 = "SELECT MAX(order_id) FROM orders";
    $result1 = $conn->query($query1);
    if ($result1) {
        $res = $result1->fetch_row();
        $id = $res[0];
    }

    while ($row1 = $result->fetch_assoc()) {
        $product_query = "SELECT * FROM products WHERE product_id = ?";
        $product_stmt = $conn->prepare($product_query);
        $product_stmt->bind_param("i", $row1['p_id']);
        $product_stmt->execute();
        $product_result = $product_stmt->get_result();
        $product_row = $product_result->fetch_assoc();
        $price = $product_row['product_price'] * $row1['qty'];

        $order_query1 = "INSERT INTO orders_info (`order_id`, `product_id`, `qty`, `amt`)
                        VALUES (?,?,?,?)";
        $order_stmt1 = $conn->prepare($order_query1);
        $order_stmt1->bind_param("iiii" , $id, $row1['p_id'], $row1['qty'], $price);
        $order_stmt1->execute();
        $order_stmt1->close();
        
        $prod_query = "UPDATE products SET quantity = quantity - ? WHERE product_id = ?";
        $prod_stmt = $conn->prepare($prod_query);
        $prod_stmt->bind_param("ii",  $row['qty'], $row['p_id']);
        $prod_stmt->execute();
        $prod_stmt->close();
    }

    $del_query = "DELETE FROM cart WHERE user_id = ?";
    $del_stmt = $conn->prepare($del_query);
    $del_stmt->bind_param("i", $_SESSION['uid']);
    $del_stmt->execute();
    $del_stmt->close();

    echo json_encode(["success" => true, "message" => "Đơn hàng đã được đặt thành công."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    CloseCon($conn);
}
?>
