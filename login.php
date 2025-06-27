<?php
session_start();
include('dp.php');  // Bao gồm file dp.php

if (isset($_POST['dangnhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = $_POST['password'];

    if ($conn) { 
        $sql = "SELECT * FROM tbl_admin WHERE username = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taikhoan);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($matkhau, $admin['password'])) { 
            $_SESSION['dangnhap'] = $admin['username'];
            $_SESSION['admin_status'] = $admin['admin_status']; 
            
            echo "<script>
                localStorage.setItem('username', '".$admin['username']."');
                window.location.href = 'giaodien.html';
            </script>";
        } else {
            echo "<script>alert('Tên đăng nhập hoặc mật khẩu không đúng!');</script>";
        }
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="login-background">
    <div class="login-box">
        <h2>ĐĂNG NHẬP</h2>
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<input type="text" placeholder="Nhập tên đăng nhập" name="username" id=""><br>
		<div class="password-wrapper">
			<input type="password" placeholder="Nhập mật khẩu" name="password" id="password">
			<span class="toggle-password" onclick="togglePassword()">
				<i class="fas fa-eye" id="eye-icon"></i>
			</span>
		</div><br>
		<input type="submit" name="dangnhap" value="Đăng nhập">
	</form>

		<a href="forgot_password.php">Bạn quên mật khẩu?</a>
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
    </script>
</body>
</html>