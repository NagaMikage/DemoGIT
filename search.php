<?php
header('Content-Type: application/json');
include('dp.php'); // Kết nối cơ sở dữ liệu

$search = isset($_GET['query']) ? $_GET['query'] : '';

if ($search) {
    $search = mysqli_real_escape_string($conn, $search);
    $query = "SELECT * FROM sanpham WHERE ten_sanpham LIKE '%$search%'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($products); // Trả về kết quả dạng JSON
    } else {
        echo json_encode(array('error' => 'Không tìm thấy sản phẩm nào.'));
    }
} else {
    echo json_encode(array('error' => 'Không có từ khóa tìm kiếm.'));
}
?>
