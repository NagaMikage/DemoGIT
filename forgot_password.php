<?php
session_start();
include('dp.php'); // Bao gồm file kết nối cơ sở dữ liệu

if (isset($_POST['submit'])) {
    $contact = $_POST['contact'];  // Số điện thoại hoặc email người dùng nhập vào

    // Kiểm tra xem contact là email hay số điện thoại
    if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM tbl WHERE email = ? LIMIT 1";
    } else {
        $sql = "SELECT * FROM tbl WHERE dienthoai = ? LIMIT 1";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Tạo mã OTP
        $otp = rand(100000, 999999);

        // Lưu OTP vào session hoặc cơ sở dữ liệu
        $_SESSION['otp'] = $otp;
        $_SESSION['contact'] = $contact;

        // Gửi OTP qua email hoặc số điện thoại
        if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
            // Gửi OTP qua email
            mail($contact, "Mã OTP của bạn", "Mã OTP của bạn là: $otp");
        } else {
            // Gửi OTP qua SMS (sử dụng API của Twilio hoặc nhà mạng)
            // Ví dụ cho Twilio:
            // sendSms($contact, "Mã OTP của bạn là: $otp");
        }

        // Chuyển hướng người dùng đến trang xác nhận OTP
        header("Location: verify_otp.php");
    } else {
        echo "<script>alert('Không tìm thấy tài khoản với thông tin liên lạc đã nhập!');</script>";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quên mật khẩu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="login-background">
    <div class="login-box">
        <h2>Quên mật khẩu</h2>
        <form action="forgot_password.php" method="post">
            <input type="text" placeholder="Nhập email hoặc số điện thoại" name="contact" required><br>
            <input type="submit" name="submit" value="Gửi OTP">
        </form>
        <a href="login.php">Quay lại trang đăng nhập</a>
    </div>
</body>
</html>
