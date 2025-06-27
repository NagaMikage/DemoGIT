<?php
session_start();
include('dp.php');  // Bao gồm file kết nối cơ sở dữ liệu

if (isset($_POST['reset'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $contact = $_SESSION['contact'];

    // Cập nhật mật khẩu trong cơ sở dữ liệu
    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE tbl SET matkhau = ? WHERE email = ?";
    } else {
        $sql = "UPDATE tbl SET matkhau = ? WHERE dienthoai = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_password, $contact);
    $stmt->execute();

    // Xóa session OTP và contact
    unset($_SESSION['otp']);
    unset($_SESSION['contact']);

    echo "<script>alert('Mật khẩu của bạn đã được đặt lại!'); window.location.href = 'login.php';</script>";
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-background">
    <div class="login-box">
        <h2>Đặt lại mật khẩu</h2>
        <form action="reset_password.php" method="post">
            <input type="password" placeholder="Nhập mật khẩu mới" name="new_password" required><br>
            <input type="submit" name="reset" value="Đặt lại mật khẩu">
        </form>
    </div>
</body>
</html>
