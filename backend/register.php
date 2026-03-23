<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Thực hiện truy vấn để lưu người dùng vào cơ sở dữ liệu
    $sql = "INSERT INTO user_management  (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<div class="success">Đăng ký thành công!</div>';
    } else {
        echo '<div class="error">Lỗi: ' . $conn->error . '</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
    <div class="container">
        <h2><?php echo "Đăng ký tài khoản"; ?></h2>
        <form method="POST" action="register.php">
            <label for="username"><?php echo "Tên người dùng:"; ?></label>
            <input type="text" name="username" id="username" required>

            <label for="email"><?php echo "Email:"; ?></label>
            <input type="email" name="email" id="email" required>

            <label for="password"><?php echo "Mật khẩu:"; ?></label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="<?php echo "Đăng ký"; ?>">
        </form>
        <p><a href="login.php"><?php echo "Đã có tài khoản? Đăng nhập tại đây"; ?></a></p>
    </div>
    
    
</body>
</html>
