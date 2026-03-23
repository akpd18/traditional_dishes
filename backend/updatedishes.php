<?php
include 'config.php';

// Lấy id món ăn cần cập nhật từ URL
$id = $_GET['id'];

// Kiểm tra nếu form được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $category = $_POST['category'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Kiểm tra nếu có hình ảnh mới được tải lên
if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
    // Xử lý upload file hình ảnh
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra nếu file là ảnh
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Đây không phải là một hình ảnh.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
        // Nếu file đã tồn tại, thêm số ngẫu nhiên vào tên file (để không trùng với file cũ)
        $fileNameWithoutExt = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_FILENAME);
        $target_file = $target_dir . $fileNameWithoutExt . "_" . uniqid() . "." . $imageFileType;
    }

    // Kiểm tra kích thước file
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "File quá lớn. Vui lòng chọn file dưới 5MB.";
        $uploadOk = 0;
    }

    // Kiểm tra loại file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Chỉ cho phép file JPG, JPEG, PNG & GIF.";
        $uploadOk = 0;
    }

    // Nếu không có lỗi trong quá trình upload
    if ($uploadOk == 1) {
        // Di chuyển file từ temp đến thư mục ảnh
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Cập nhật hình ảnh mới vào cơ sở dữ liệu
            $image = $target_file;
        } else {
            echo "Có lỗi trong quá trình upload hình ảnh.";
        }
    } else {
        echo "Có lỗi trong quá trình upload file.";
    }
} else {
    // Nếu không có hình ảnh mới, giữ lại hình ảnh cũ
    $image = $_POST['current_image'];
}

    // Cập nhật thông tin món ăn vào cơ sở dữ liệu
    $sql = "UPDATE dishes SET name = '$name', category = '$category', image = '$image', description = '$description', price = '$price' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Sau khi cập nhật thành công, chuyển hướng về trang index
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

// Lấy dữ liệu của món ăn cần cập nhật
$sql = "SELECT * FROM dishes WHERE id = $id";
$result = $conn->query($sql);
$dish = $result->fetch_assoc(); // Lấy 1 bản ghi
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật món ăn</title>
    <link rel="stylesheet" href="css/updatestyle.css">
</head>
<body>

<h1>Cập nhật món ăn</h1>

<form action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><label>Tên món ăn:</label></td>
            <td><input type="text" name="name" value="<?php echo $dish['name']; ?>" required><br></td>
        </tr>

        <tr>
            <td><label>Loại món ăn:</label></td>
            <td><input type="text" name="category" value="<?php echo $dish['category']; ?>" required><br></td>
        </tr>

        <tr>
            <td><label>Hình ảnh món ăn:</label></td>
            <td>
                <input type="file" name="fileToUpload" id="fileToUpload"><br>
                <img src="<?php echo $dish['image']; ?>" alt="Current Image" width="100px"><br>
            </td>
        </tr>

        <tr>
            <td><label>Mô tả:</label></td>
            <td><textarea name="description" required><?php echo $dish['description']; ?></textarea><br></td>
        </tr>

        <tr>
            <td><label>Giá:</label></td>
            <td><input type="text" name="price" value="<?php echo $dish['price']; ?>" step="0.01" required><br></td>
        </tr>

        <!-- Lưu hình ảnh cũ để nếu không tải lên ảnh mới thì vẫn giữ lại ảnh cũ -->
        <input type="hidden" name="current_image" value="<?php echo $dish['image']; ?>">

        <tr>
            <td colspan="2"><input type="submit" class="btnCapNhat" value="Cập nhật món ăn"></td>
        </tr>
    </table>
</form>

</body>
</html>
