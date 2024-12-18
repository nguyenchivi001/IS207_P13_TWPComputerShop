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

    $query1 = "SELECT MAX(order_id) FROM orders_info";
    $result1 = $conn->query($query1);
    $id = 1;
    if ($result1) {
        $row = $result1->fetch_row();
        $id = $row ? $row[0] + 1 : 1;
    }

    $order_query = "INSERT INTO orders_info (`order_id`, `user_id`, `f_name`, `email`, `address`, `city`, `state`, `zip`, `cardname`, `cardnumber`, `expdate`, `prod_count`, `total_amt`, `cvv`)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $state = "Viet Nam";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("iisssssssssiis", $id, $_SESSION['uid'], $fname, $email, $address, $city, $state, $zip, $cardname, $cardNumber, $expdate, $total_items, $_SESSION['total_price'], $cvv);
    $order_stmt->execute();
    $order_stmt->close();
    
    $query = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $order_query1 = "INSERT INTO orders (`order_id`, `user_id`, `product_id`, `trx_id`, `qty`, p_status)
                        VALUES (?,?,?,?,?,?)";
        $trx_id="defaulf";
        $p_status="Uncomplete";
        $order_stmt1 = $conn->prepare($order_query1);
        $order_stmt1->bind_param("iiisis", $id , $_SESSION['uid'], $row['p_id'], $trx_id, $row['qty'], $p_status);
        $order_stmt1->execute();
        $order_stmt1->close();

        $query2 = "SELECT MAX(order_pro_id) FROM order_products";
        $result2 = $conn->query($query2);
        $o_id = 1;
        if ($result2) {
            $row1 = $result2->fetch_row();
            $o_id = $row1 ? $row1[0] + 1 : 1;
        }

        $order_prod_query = "INSERT INTO order_products (`order_pro_id`, `order_id`, `product_id`, `qty`, `amt`)
                        VALUES (?,?,?,?,?)";
        $order_prod_stmt = $conn->prepare($order_prod_query);
        $order_prod_stmt->bind_param("iiiii", $o_id, $id,  $row['p_id'], $row['qty'], $_SESSION['total_price']);
        $order_prod_stmt->execute();
        $order_prod_stmt->close();
        
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
