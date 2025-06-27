<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_mysqli";

// Kiểm tra nếu kết nối chưa được tạo
if (!isset($conn)) {
    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }
}
?>
