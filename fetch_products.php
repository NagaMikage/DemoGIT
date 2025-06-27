<?php
// Kết nối tới database
include('dp.php');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn lấy danh sách sản phẩm từ bảng sanpham
$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);

// Khởi tạo mảng để chứa dữ liệu sản phẩm
$products = array();

if ($result->num_rows > 0) {
 
    while ($row = $result->fetch_assoc()) {
        $product = array(
            'id' => $row['id'],
            'ten_sanpham' => $row['ten_sanpham'],
            'gia' => number_format($row['gia'] <= 120000, 0, ',', '.'),
            'hinhanh' => $row['hinhanh']
        );
        $products[] = $product;
    }
} else {
    $products['error'] = "Không có sản phẩm nào!";
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode($products);

// Đóng kết nối
$conn->close();
?>
