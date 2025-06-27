<?php
// Kết nối với cơ sở dữ liệu
include 'dp.php';

// Thêm tin tức
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieude = $_POST['tieude'];
    $noidung = $_POST['noidung'];

    $query = "INSERT INTO tbl_news (tieude, noidung) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $tieude, $noidung);
    $stmt->execute();

    header("Location: news_list.php"); // Quay lại trang danh sách tin tức
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm tin tức</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>
    <h1>Thêm tin tức</h1>

    <form action="" method="POST">
        <input type="text" name="tieude" placeholder="Tiêu đề" required>
        <textarea name="noidung" id="editor" required></textarea>
        <button type="submit">Thêm tin tức</button>
    </form>

    <script>
        CKEDITOR.replace('noidung');
    </script>
</body>
</html>
