<?php
// Kết nối đến cơ sở dữ liệu
include 'dp.php'; // Giả sử bạn đã có file dp.php để kết nối

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['tendm'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['pass'];
    $confirmPassword = $_POST['confirm_pass'];
    $phone = $_POST['phone'];

    // Kiểm tra mật khẩu
    if ($password !== $confirmPassword) {
        echo "<script>alert('Mật khẩu không khớp!');</script>";
    } else {
        // Mã hóa mật khẩu trước khi lưu vào CSDL
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Chuẩn bị câu lệnh SQL để thêm người dùng vào bảng tbl
        $sql = "INSERT INTO tbl (user_dangki, email, diachi, matkhau, dienthoai) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $email, $address, $hashedPassword, $phone);

        if ($stmt->execute()) {
            // Thêm người dùng vào bảng tbl_admin với admin_status = 0
            $sqlAdmin = "INSERT INTO tbl_admin (username, password, admin_status) VALUES (?, ?, 0)";
            $stmtAdmin = $conn->prepare($sqlAdmin);
            $stmtAdmin->bind_param("ss", $username, $hashedPassword);
            $stmtAdmin->execute();
            $stmtAdmin->close();

            echo "<script>alert('Đăng ký thành công!');</script>";
            // Chuyển hướng đến trang đăng nhập
            header("Location: login.php");
            exit();
        } else {
            echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại.');</script>";
        }

        $stmt->close();
    }
}
?>


<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="register-background">
    <div class="register-box">
        <h2>ĐĂNG KÝ</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <input type="text" placeholder="Nhập tên đăng nhập" name="tendm" required><br>
            <input type="email" placeholder="Nhập email" name="email" required><br>
            <input type="tel" placeholder="Nhập số điện thoại" name="phone" required><br>
            <input type="text" placeholder="Nhập địa chỉ" name="address" required><br>
            <div class="password-wrapper">
                <input type="password" placeholder="Nhập mật khẩu" name="pass" id="password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="eye-icon"></i>
                </span>
            </div><br>
            <div class="password-wrapper">
                <input type="password" placeholder="Xác nhận mật khẩu" name="confirm_pass" id="confirm-password" required>
                <span class="toggle-password" onclick="toggleConfirmPassword()">
                    <i class="fas fa-eye" id="confirm-eye-icon"></i>
                </span>
            </div><br>
            <input type="submit" name="register" value="Đăng ký">
        </form>
        <a href="login.php">Bạn đã có tài khoản? Đăng nhập</a>
    </div>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        function toggleConfirmPassword() {
            var confirmPasswordInput = document.getElementById("confirm-password");
            var confirmEyeIcon = document.getElementById("confirm-eye-icon");
            if (confirmPasswordInput.type === "password") {
                confirmPasswordInput.type = "text";
                confirmEyeIcon.classList.remove("fa-eye");
                confirmEyeIcon.classList.add("fa-eye-slash");
            } else {
                confirmPasswordInput.type = "password";
                confirmEyeIcon.classList.remove("fa-eye-slash");
                confirmEyeIcon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
