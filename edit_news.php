<?php
// Kết nối với cơ sở dữ liệu
include 'dp.php';

// Kiểm tra nếu ID đã được truyền vào
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Lấy thông tin tin tức
    $query = "SELECT * FROM tbl_news WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();
    
    // Cập nhật tin tức
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tieude = $_POST['tieude'];
        $noidung = $_POST['noidung'];

        $updateQuery = "UPDATE tbl_news SET tieude = ?, noidung = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param('ssi', $tieude, $noidung, $id);
        $updateStmt->execute();

        header("Location: news_list.php"); // Quay lại trang danh sách tin tức
    }
} else {
    // Nếu không có ID thì quay lại trang danh sách
    header("Location: news_list.php");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa tin tức</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>
    <h1>Sửa tin tức</h1>

    <form action="" method="POST">
        <input type="text" name="tieude" value="<?php echo htmlspecialchars($news['tieude']); ?>" required>
        <textarea name="noidung" id="editor" required><?php echo $news['noidung']; ?></textarea>
        <button type="submit">Cập nhật tin tức</button>
    </form>

    <script>
        CKEDITOR.replace('editor');
    </script>
</body>
</html>
