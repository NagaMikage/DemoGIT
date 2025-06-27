<?php
// Kết nối tới cơ sở dữ liệu
$connect = new mysqli("localhost", "root", "", "web_mysqli");

// Kiểm tra kết nối
if ($connect->connect_errno) {
    echo "Kết nối lỗi: " . $connect->connect_error;
    exit();
}

// Lấy ID sản phẩm từ tham số GET
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id === 0) {
    echo "ID sản phẩm không hợp lệ.";
    exit();
}

// Lấy thông tin sản phẩm
$sql_product = "SELECT * FROM sanpham WHERE id = $product_id";
$query_product = mysqli_query($connect, $sql_product);

if (!$query_product) {
    echo "Lỗi truy vấn: " . mysqli_error($connect);
    exit();
}

$product = mysqli_fetch_assoc($query_product);

// Lấy danh mục sản phẩm
$sql_category = "SELECT * FROM danhmucsanpham";
$query_category = mysqli_query($connect, $sql_category);

if (!$query_category) {
    echo "Lỗi truy vấn danh mục: " . mysqli_error($connect);
    exit();
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['submit'])) {
    $prd_name = $_POST['prd_name'];
    $price = $_POST['price'];
    $mota = $_POST['mota'];
    $ten_danhmuc = $_POST['ten_danhmuc'];

    // Xử lý ảnh
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    if ($image) {
        move_uploaded_file($image_tmp, 'image/'.$image);
        $image_query = ", hinhanh = '$image'";
    } else {
        $image_query = "";
    }

    $sql_update = "UPDATE sanpham SET 
        ten_sanpham = '$prd_name',
        gia = '$price',
        mota = '$mota',
        id_admin = '$ten_danhmuc'
        $image_query
        WHERE id = $product_id";

    $query_update = mysqli_query($connect, $sql_update);

    if ($query_update) {
        header('Location: sanpham.php');
        exit();
    } else {
        echo "Lỗi cập nhật: " . mysqli_error($connect);
    }
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sửa sản phẩm</title>
<!-- Thêm CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#mota'))
            .catch(error => {
                console.error(error);
            });
    });
</script>
<style>
    body {
        font-family: Arial, sans-serif;
    }
    .container-fluid {
        padding: 20px;
    }
    .card {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        background-color: #fff;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .btn-success {
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }
    .btn-success:hover {
        background-color: #218838;
    }
    img {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
    }
</style>
</head>
<body>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2>Sửa sản phẩm</h2>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="prd_name">Tên sản phẩm</label>
                        <input type="text" name="prd_name" class="form-control" id="prd_name" value="<?php echo htmlspecialchars($product['ten_sanpham']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Giá sản phẩm</label>
                        <input type="number" name="price" class="form-control" id="price" value="<?php echo htmlspecialchars($product['gia']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Ảnh sản phẩm</label><br>
                        <input type="file" name="image" id="image">
                        <?php if ($product['hinhanh']) { ?>
                            <br><img src="image/<?php echo $product['hinhanh']; ?>">
                        <?php } ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="mota">Mô tả sản phẩm</label>
                        <textarea name="mota" class="form-control" id="mota"><?php echo htmlspecialchars($product['mota']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="ten_danhmuc">Danh mục</label>
                        <select class="form-control" name="ten_danhmuc" id="ten_danhmuc" required>
                            <?php 
                             while ($row_category = mysqli_fetch_assoc($query_category)) {
                                $selected = ($row_category['id_admin'] == $product['id_admin']) ? 'selected' : '';
                            ?>
                            <option value="<?php echo $row_category['id_admin']; ?>" <?php echo $selected; ?>><?php echo $row_category['ten_danhmuc']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <button name="submit" class="btn btn-success" type="submit">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
