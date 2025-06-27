<?php
// Kết nối tới cơ sở dữ liệu
$connect = new mysqli("localhost", "root", "", "web_mysqli");

// Kiểm tra kết nối
if ($connect->connect_errno) {
    echo "Kết nối lỗi: " . $connect->connect_error;
    exit();
}

// Câu truy vấn SQL
$sql = "SELECT * FROM sanpham INNER JOIN danhmucsanpham ON sanpham.id_admin = danhmucsanpham.id_admin";
$query = mysqli_query($connect, $sql);

if (!$query) {
    echo "Lỗi truy vấn: " . mysqli_error($connect);
}

// Kiểm tra mật khẩu
$correct_password = "1";
$access_granted = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password_input = $_POST['password'];
    if ($password_input === $correct_password) {
        $access_granted = true;
        header("Location: Them.php");
        exit();
    } else {
        echo "<script>alert('Sai mật khẩu! Vui lòng thử lại.');</script>";
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('image/backgroud.jpg');
            background-size: cover;
            background-attachment: fixed;
        }
        .container-fluid {
            padding: 20px;
        }
        thead th {
            color: white;
            background-color: #333;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 2px solid black;
        }
        th, td {
            padding: 15px;
            text-align: center;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        td img {
            max-width: 200px;
            max-height: 200px;
            object-fit: cover;
        }
        .password-form {
            display: none;
            margin-top: 20px;
            background-color: #ffffff;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 5px;
        }
        .btn-primary, .btn-success {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-primary:hover, .btn-success:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function showPasswordForm() {
            document.getElementById("passwordForm").style.display = "block";
        }
    </script>
<title>Danh sách sản phẩm</title>
</head>
<body>
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
            <h2 align="center" style="font-size: 40px;">Danh sách sản phẩm</h2>
        </div>
		  <a href="giaodien.html"><i class="fa fa-home"></i> Về trang chủ</a>
        <div class="card-body">
          <table width="100%" class="table" align="center">
              <thead class="thead-dark"> 
                  <tr>
                      <th width="27"></th>
                      <th width="140" height="45">Tên sản phẩm</th>
                      <th width="127">Giá</th>
                      <th width="336">Hình ảnh</th>
                      <th width="540">Mô tả</th>
                      <th width="139">Danh mục</th>
                      <th width="44">Sửa</th>
                      <th width="45">Xóa</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $i = 1;
                    while ($row = mysqli_fetch_assoc($query)) { ?>
                  <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['ten_sanpham']; ?></td>
                  <td><?php echo number_format($row['gia'], 0, ',', '.'); ?> VNĐ</td>
                  <td><img src="image/<?php echo $row['hinhanh']; ?>" alt="<?php echo $row['ten_sanpham']; ?>"></td>
                  <td><?php echo $row['mota']; ?></td>
                  <td><?php echo $row['ten_danhmuc']; ?></td>
                  <td><a href="password.php?action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a></td>
                  <td><a href="password.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return Del('<?php echo $row['ten_sanpham']; ?>')">Xóa</a></td>
                </tr>    
                <?php } ?>
              </tbody>
          </table>

          <button class="btn btn-primary" onclick="showPasswordForm()">Thêm sản phẩm</button>

          <div id="passwordForm" class="password-form">
              <form method="POST">
                  <label for="password">Nhập mật khẩu để thêm sản phẩm:</label>
                  <input type="password" name="password" required>
                  <button type="submit" class="btn btn-success">Xác nhận</button>
              </form>
          </div>
        </div>
      </div>
    </div>
    <script>
        function Del(name){
            return confirm("Bạn có chắc muốn xóa sản phẩm: " + name + "?");
        }
    </script>
</body>
</html>
