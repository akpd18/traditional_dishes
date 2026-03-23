<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu không
    $sql = "SELECT * FROM user_management WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            echo '<div class="success">Đăng nhập thành công!</div>';
            header("Location: index.php");
        } else {
            echo '<div class="error">Sai mật khẩu!</div>';
        }
    } else {
        echo '<div class="error">Email chưa được đăng ký!</div>';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
    <div class="container">
        <h2><?php echo "Đăng nhập"; ?></h2>
        <form method="POST" action="login.php">
            <label for="email"><?php echo "Email:"; ?></label>
            <input type="email" name="email" id="email" required>

            <label for="password"><?php echo "Mật khẩu:"; ?></label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="<?php echo "Đăng nhập"; ?>">
        </form>
        <p><a href="register.php"><?php echo "Chưa có tài khoản? Đăng ký tại đây"; ?></a></p>
    </div>
    
    
</body>
</html>
