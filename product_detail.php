<?php
include('dp.php'); // Kết nối cơ sở dữ liệu

$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $search = mysqli_real_escape_string($conn, $search);
    $query = "SELECT * FROM sanpham WHERE ten_sanpham LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $products = array('error' => 'Không tìm thấy sản phẩm nào.');
    }
} else {
    $products = array('error' => 'Không có từ khóa tìm kiếm.');
}

mysqli_close($conn);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<title>Chi Tiết Sản Phẩm</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #FFCE80;
        font-family: Arial, sans-serif;
    }
    header {
        text-align: center;
        padding: 20px;
    }
    .product-detail {
        background-color: #FFF;
        padding: 20px;
        margin: 20px auto;
        width: 80%;
        max-width: 800px;
        border: 1px solid #000;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .product-detail img {
        max-width: 100%;
        height: auto;
        border: 1px solid #000;
        border-radius: 5px;
        display: block;
        margin: 0 auto;
    }
    .product-detail h1 {
        text-align: center;
        font-size: 24px;
        margin: 10px 0;
        color: #000;
    }
    .product-detail p {
        font-size: 18px;
        color: #000;
        margin: 10px 0;
    }
    .btn-cart {
        display: block;
        width: 100%;
        max-width: 200px;
        margin: 20px auto;
        text-align: center;
        background-color: #007bff;
        color: #FFF;
        padding: 10px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-size: 18px;
        cursor: pointer;
    }
    .btn-cart:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
    <div class="product-detail">
        <?php if (isset($products['error'])): ?>
            <p><?php echo $products['error']; ?></p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-item">
                    <img src="image/<?php echo $product['hinhanh']; ?>" alt="<?php echo $product['ten_sanpham']; ?>">
                    <h1><?php echo $product['ten_sanpham']; ?></h1>
                    <p><strong>Giá:</strong> <?php echo number_format($product['gia'], 0, ',', '.'); ?> VNĐ</p>
                    <p><strong>Mô tả:</strong> <?php echo $product['mota']; ?></p>
                    <p><a href="add_to_cart.php?id=<?php echo $product['id']; ?>" class="btn-cart"><i class="fa fa-cart-shopping" aria-hidden="true"></i> Thêm vào giỏ hàng</a></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
