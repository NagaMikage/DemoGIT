<?php
session_start();
include('dp.php');  // Bao gồm file kết nối cơ sở dữ liệu

if (isset($_POST['verify'])) {
    $otp = $_POST['otp'];

    // Kiểm tra OTP
    if ($otp == 9999) {
        // OTP đúng, cho phép người dùng đổi mật khẩu
        header("Location: reset_password.php");
    } else {
        echo "<script>alert('Mã OTP không đúng!');</script>";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận OTP</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-background">
    <div class="login-box">
        <h2>Xác nhận OTP</h2>
        <form action="verify_otp.php" method="post">
            <input type="text" placeholder="Nhập mã OTP" name="otp" required><br>
            <input type="submit" name="verify" value="Xác nhận">
        </form>
    </div>
</body>
</html>
