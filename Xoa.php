<?php
// Kết nối tới cơ sở dữ liệu
$connect = new mysqli("localhost", "root", "", "web_mysqli");

// Kiểm tra kết nối
if ($connect->connect_errno) {
    echo "Kết nối lỗi: " . $connect->connect_error;
    exit();
}

// Lấy ID sản phẩm từ tham số GET
$ten_sanpham= isset($_GET['ten_sanpham']) ? (int)$_GET['ten_sanpham'] : 0;

if ($id === 0) {
    echo "ID sản phẩm không hợp lệ.";
    exit();
}

// Xóa sản phẩm
$sql = "DELETE FROM sanpham WHERE ten_sanpham = $ten_sanpham";
$query = mysqli_query($connect, $sql);

if ($query) {
    header('Location: sanpham.php');
    exit();
} else {
    echo "Lỗi xóa sản phẩm: " . mysqli_error($connect);
}

// Đóng kết nối
$connect->close();
?>
