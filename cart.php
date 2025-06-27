<?php
session_start();
include 'dp.php';  // Kết nối với cơ sở dữ liệu

// Xử lý thêm sản phẩm vào giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = $_GET['id'];
    $query = "SELECT * FROM sanpham WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $product = mysqli_fetch_assoc($result);
        
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                "name" => $product['ten_sanpham'],
                "price" => $product['gia'],
                "quantity" => 1,
                "image" => $product['hinhanh']  
            ];
        }
    } else {
        die('Lỗi truy vấn: ' . mysqli_error($conn));
    }
    header('Location: cart.php');
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = $_GET['id'];
    unset($_SESSION['cart'][$id]);
    header('Location: cart.php');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .cart-container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .cart-header h2 {
            margin: 0;
        }
        .cart-items {
            margin: 20px 0;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            width: 100px;
        }
        .cart-item-info {
            flex-grow: 1;
            margin-left: 20px;
        }
        .cart-item-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .cart-item-actions button {
            margin-top: 10px;
        }
        .cart-total {
            text-align: right;
            font-size: 24px;
            margin-top: 20px;
        }
        .checkout-button {
            display: block;
            text-align: center;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #FF5F17;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="cart-container">
        <div class="cart-header">
            <h2>Giỏ hàng của bạn</h2>
            <a href="giaodien.html"><i class="fa fa-home"></i> Về trang chủ</a>
        </div>

        <div class="cart-items">
            <?php
            $total = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id => $product) {
                    $subtotal = $product['price'] * $product['quantity'];
                    $total += $subtotal;
                    echo '
                    <div class="cart-item">
                        <img src="image/' . $product['image'] . '" alt="' . $product['name'] . '">
                        <div class="cart-item-info">
                            <p>' . $product['name'] . '</p>
                            <p>' . number_format($product['price'], 0, ',', '.') . ' VND</p>
                            <p>Số lượng: ' . $product['quantity'] . '</p>
                        </div>
                        <div class="cart-item-actions">
                            <a href="cart.php?action=remove&id=' . $id . '">
                                <button>Xóa</button>
                            </a>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '<p>Giỏ hàng của bạn đang trống!</p>';
            }
            ?>
        </div>

        <div class="cart-total">
            Tổng tiền: <span id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?></span> VND
        </div>

        <a href="thanhtoan.php" class="checkout-button">Thanh toán</a>
    </div>

</body>
</html>
