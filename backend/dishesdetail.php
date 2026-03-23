<?php
include 'config.php';  // Kết nối với cơ sở dữ liệu

// Lấy ID món ăn từ URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;  // Kiểm tra xem có ID trong URL hay không

// Kiểm tra ID hợp lệ
if ($id > 0) {
    // Truy vấn thông tin món ăn dựa trên ID
    $sql = "SELECT * FROM dishes WHERE id = $id";
    $result = $conn->query($sql);

    // Kiểm tra nếu có kết quả từ truy vấn
    if ($result->num_rows > 0) {
        // Lấy dữ liệu món ăn
        $d = $result->fetch_assoc();
    } else {
        // Nếu không tìm thấy món ăn với ID đó
        echo "Không tìm thấy món ăn!";
        exit;
    }
} else {
    // Nếu không có ID hợp lệ
    echo "ID không hợp lệ!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết món ăn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #B9D6F3;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            background-color: #F1E8D9;
            border: 2px solid #000; 
            border-radius: 15px;
            padding: 10px;  
            width: fit-content; 
            font-family: Arial, sans-serif; 
        }

        .dish-image {
            display: block; 
            margin: 0 auto; 
            max-width: 100%; 
            height: 400px; 
        }

        .dish-details {
            margin-top: 20px;
        }

        .dish-details h2 {
            color: #333;
        }

        .dish-details p {
            font-size: 1.2em;
            line-height: 1.6;
            color: #555;
        }

        .btnBack {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .btnBack:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
        
    <div class="container">
        <h1>Chi tiết món ăn</h1>
        
        <img src="<?php echo $d['image'];; ?>" alt="<?php echo $d['name']; ?>" class="dish-image">

        <div class="dish-details">
            <h2><?php echo $d['name']; ?></h2>
            <p><?php echo nl2br($d['description']); ?></p> <!-- Mô tả đầy đủ -->
            <p><strong>Giá:</strong> <b><?php echo number_format($d['price'], 0, ',', '.') . ' VND'; ?></b></p>
        </div>

        <!-- Nút quay lại -->
        <a href="index.php" class="btnBack">Quay lại danh sách món ăn</a>
    </div>

</body>
</html>
