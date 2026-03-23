<?php
include 'config.php'; // Kết nối cơ sở dữ liệu
include 'upload.php';
// Lấy các món ăn thuộc danh mục "nước"
$sql_nuoc = "SELECT * FROM dishes WHERE category = 'nước'";
$dishes_nuoc = $conn->query($sql_nuoc);

// Lấy các món ăn thuộc danh mục "khô"
$sql_kho = "SELECT * FROM dishes WHERE category = 'khô'";
$dishes_kho = $conn->query($sql_kho);

// Kiểm tra nếu có tìm kiếm từ người dùng
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Nếu có từ khóa tìm kiếm, thực hiện truy vấn để tìm kiếm món ăn
if ($query) {
    $sql_nuoc = "SELECT * FROM dishes WHERE category = 'nước' AND name LIKE '%$query%'";
    $dishes_nuoc = $conn->query($sql_nuoc);

    $sql_kho = "SELECT * FROM dishes WHERE category = 'khô' AND name LIKE '%$query%'";
    $dishes_kho = $conn->query($sql_kho);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Giới Thiệu Món Ăn</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<!-- Thanh điều hướng -->
<div class="navbar">
    <a href="index.php">Trang Chủ</a>
    <a href="#nuoc">Món Nước</a>
    <a href="#kho">Món Khô</a>
    <a href="adddishes.php">Thêm mới món ăn</a>

    <!-- Form tìm kiếm -->
    <form action="index.php" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Tìm món ăn..." class="search-input" value="<?php echo htmlspecialchars($query); ?>">
        <button type="submit" class="search-button">Tìm</button>
    </form>

</div>

<!-- Nội dung chính -->
<div class="container">
    <h1>Món ăn truyền thống</h1>

    <!-- Danh mục Đồ ăn Nước -->
    <div class="category-section">
        <div class="category-title" id="nuoc">Món Nước</div>
        <div class="dish-list">
            <?php while ($d = $dishes_nuoc->fetch_assoc()) { ?>
                <div class="dish-item">
                    <img src="<?php echo $d['image']; ?>" alt="<?php echo $d['name']; ?>">
                    <h3><?php echo $d['name']; ?></h3>
                    <p class="price"><?php echo number_format($d['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a href="dishesdetail.php?id=<?php echo $d['id']; ?>" class="button">Xem chi tiết</a>
                    <a href="updatedishes.php?id=<?php echo $d['id']; ?>" class="button">Cập nhật món ăn</a>
                    <a href="deletedishes.php?id=<?php echo $d['id']; ?>" class="button">Xóa món ăn</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Danh mục Đồ ăn Khô -->
    <div class="category-section">
        <div class="category-title" id="kho">Món Khô</div>
        <div class="dish-list">
            <?php while ($d = $dishes_kho->fetch_assoc()) { ?>
                <div class="dish-item">
                    <img src="<?php echo $d['image']; ?>" alt="<?php echo $d['name']; ?>">
                    <h3><?php echo $d['name']; ?></h3>
                    <p class="price"><?php echo number_format($d['price'], 0, ',', '.'); ?> VNĐ</p>
                    <a href="dishesdetail.php?id=<?php echo $d['id']; ?>" class="button">Xem chi tiết</a>
                    <a href="updatedishes.php?id=<?php echo $d['id']; ?>" class="button">Cập nhật món ăn</a>
                    <a href="deletedishes.php?id=<?php echo $d['id']; ?>" class="button">Xóa món ăn</a>
                </div>
            <?php } ?>
        </div>
    </div>

</div>

</body>
</html>
