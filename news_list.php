<?php
// Kết nối với cơ sở dữ liệu
include 'dp.php';

// Xóa tin tức
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM tbl_news WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

// Lấy danh sách tin tức
$query = "SELECT * FROM tbl_news ORDER BY ngaydang DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin tức</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>
	<a href="giaodien.html"><i class="fa fa-home"></i> Về trang chủ</a>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div>
            <h1 style="color: green"><?php echo htmlspecialchars($row['tieude']); ?></h1>
            <div><?php echo $row['noidung']; ?></div>
            <p>Ngày đăng: <?php echo $row['ngaydang']; ?></p>

            <!-- Link để xóa tin tức -->
            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
			<a href="edit_news.php?id=<?php echo $row['id']; ?>">Sửa</a>
			
        </div>
    <?php endwhile; ?>
    <a href="add_news.php">Thêm tin tức</a>
</body>
</html>
