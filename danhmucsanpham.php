<?php
$mysqli = new mysqli("localhost", "root", "", "web_mysqli");

// Check connection
if ($mysqli->connect_errno) {
    echo "Kết nối lỗi: " . $mysqli->connect_error;
    exit();
}

// Sửa sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'edit') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            
            // Cập nhật sản phẩm trong cơ sở dữ liệu
            $stmt = $mysqli->prepare("UPDATE products SET name=?, price=?, description=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $price, $description, $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Lấy danh sách sản phẩm
$result = $mysqli->query("SELECT * FROM products");
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Danh mục Sản phẩm</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
</head>
<body>
    <h1>Danh mục Sản phẩm</h1>
    
    <!-- Danh sách sản phẩm -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Chỉnh sửa</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form action="danhmucsanpham.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required></td>
                <td><input type="text" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" required></td>
                <td><textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea></td>
                <td><button type="submit">Cập nhật</button></td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <?php $mysqli->close(); ?>
</body>
</html>
