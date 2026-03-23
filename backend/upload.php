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
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Đây không phải file hình";
            $uploadOk = 0;
        }

        // Check if file already exists, nếu trùng tên thì đổi tên file
        if (file_exists($target_file)) {
            $target_file = $target_dir . uniqid() . basename($_FILES["fileToUpload"]["name"]);
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "File quá lớn (vui lòng chọn file dưới 5MB).";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
            echo "Chỉ cho phép loại file JPG, JPEG, PNG & GIF.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Upload không thành công.";
        } else {
            // Nếu upload thành công
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "Tập tin ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " đã được upload lên server.";
            } else {
                echo "Có lỗi trong quá trình upload file.";
            }
        }

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
