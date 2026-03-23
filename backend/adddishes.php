<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy các dữ liệu từ form
    $name = $_POST['name']; 
    $category = $_POST['category'];      
    $image = $_POST['image'];
    $description = $_POST['description']; 
    $price = $_POST['price'];         

    // Kiểm tra nếu file đã được upload và lấy đường dẫn ảnh
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        // Xử lý upload file
        include 'upload.php';  

        // Sau khi upload thành công, lấy đường dẫn ảnh
        if ($uploadOk == 1) {
            $image = $target_file;  
            
            // Insert vào database
            $sql = "INSERT INTO dishes (name, category, image, description, price) 
                    VALUES ('$name', '$category', '$image', '$description', '$price')";
        
            if ($conn->query($sql) === TRUE) {
                // Sau khi thêm thành công, chuyển hướng về trang index
                header("Location: index.php"); 
                exit();  
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Có lỗi trong quá trình tải lên tệp tin.";
        }
    } else {
        echo "Vui lòng chọn tệp tin để tải lên và gửi form.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm món ăn</title>
    <link rel="stylesheet" href="css/addstyle.css">
</head>
<body>

    <h1>Thêm món ăn mới</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label>Tên món ăn</label></td>
                <td><input type="text" name="name" required><br></td>
            </tr>
            <tr>
                <td><label>Loại món ăn (nước hoặc khô)</label></td>
                <td><input type="text" name="category" required><br></td>
            </tr>
            <tr>
                <td><label>Hình món ăn</label></td>
                <td><input type="file" name="fileToUpload" id="fileToUpload"><br></td>
            </tr>
            <tr>
                <td><label>Mô tả</label></td>
                <td><textarea name="description" required></textarea><br></td>
            </tr>
            <tr>
                <td><label>Giá</label></td>
                <td><input type="text" name="price" step="0.01" required><br></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Thêm món ăn" class="btnThem"></td>
            </tr>
        </table>
    </form>
</body>
</html>
