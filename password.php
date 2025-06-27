<?php
// Kết nối tới cơ sở dữ liệu
$connect = new mysqli("localhost", "root", "", "web_mysqli");

// Kiểm tra kết nối
if ($connect->connect_errno) {
    echo "Kết nối lỗi: " . $connect->connect_error;
    exit();
}

$correct_password = "1";  // Mật khẩu chính xác
$access_granted = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_input = $_POST['password'];
    if ($password_input === $correct_password) {
        $action = $_POST['action'];
        $id = $_POST['id'];
        
        if ($action === 'edit') {
            header("Location: Sua.php?id=$id");  
            exit();
        } elseif ($action === 'delete') {
            header("Location: Xoa.php?id=$id");  
            exit();
        }
    } else {
        echo "<script>alert('Sai mật khẩu! Vui lòng thử lại.'); window.history.back();</script>";
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Xác nhận mật khẩu</title>
</head>
<body>
    <div>
        <h2>Nhập mật khẩu để thực hiện hành động</h2>
        <form method="POST">
            <label for="password">Nhập mật khẩu:</label>
            <input type="password" name="password" required>
            <input type="hidden" name="action" value="<?php echo htmlspecialchars($_GET['action']); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <button type="submit">Xác nhận</button>
        </form>
    </div>
</body>
</html>
