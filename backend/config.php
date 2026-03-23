<?php
    // Thông tin kết nối đến server
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "food";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error){
        die("Không kết nối được với CSDL: ". $conn->connect_error);
    }
?>