<?php
// Kết nối tới cơ sở dữ liệu
$connect = new mysqli("localhost", "root", "", "web_mysqli");

// Kiểm tra kết nối
if ($connect->connect_errno) {
    echo "Kết nối lỗi: " . $connect->connect_error;
    exit();
}

// Câu truy vấn SQL
$sql_brand = "SELECT * FROM danhmucsanpham";
$query_brand = mysqli_query($connect, $sql_brand);

if (isset($_POST['submit'])) {
    $prd_name = $_POST['prd_name'];
    $gia = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $mota = $_POST['mota'];
    $ten_danhmuc = $_POST['ten_danhmuc'];
    
    // Lấy ID danh mục từ tên danh mục
    $sql_danhmuc = "SELECT id_admin FROM danhmucsanpham WHERE ten_danhmuc = '$ten_danhmuc'";
    $query_danhmuc = mysqli_query($connect, $sql_danhmuc);
    $row_danhmuc = mysqli_fetch_assoc($query_danhmuc);
    $id_admin = $row_danhmuc['id_admin'];
    
    $sql = "INSERT INTO sanpham (ten_sanpham, gia, hinhanh, mota, id_admin) VALUES ('$prd_name', '$gia', '$image', '$mota', $id_admin)";
    $query = mysqli_query($connect, $sql);

    if ($query) {
        move_uploaded_file($image_tmp, 'image/' . $image);
        header('Location: sanpham.php');
        exit();
    } else {
        echo "Lỗi thêm sản phẩm: " . mysqli_error($connect);
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Thêm sản phẩm</title>
<!-- CKEditor CDN -->
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2>Thêm sản phẩm</h2>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prd_name">Tên sản phẩm</label>
                        <input type="text" name="prd_name" class="form-control" id="prd_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Giá sản phẩm</label>
                        <input type="number" name="price" class="form-control" id="price" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Ảnh sản phẩm</label><br>
                        <input type="file" name="image" id="image" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="mota">Mô tả sản phẩm</label>
                        <textarea name="mota" class="form-control" id="mota" required></textarea>
                        <script>
                            CKEDITOR.replace('mota');
                        </script>
                    </div>
                    
                    <div class="form-group">
                        <label for="ten_danhmuc">Danh mục</label>
                        <select class="form-control" name="ten_danhmuc" id="ten_danhmuc" required>
                            <?php 
                             while ($row_brand = mysqli_fetch_assoc($query_brand)) {
                            ?>
                            <option value="<?php echo $row_brand['ten_danhmuc']; ?>"><?php echo $row_brand['ten_danhmuc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <button name="submit" class="btn btn-success" type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
